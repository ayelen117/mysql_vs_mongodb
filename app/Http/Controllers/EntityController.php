<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;
use App\Models\Mysql\Entity as MysqlEntity;
use App\Models\MongoDB\Entity as MongoEntity;

class EntityController extends Controller
{
    public $client;
    public $entities;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->entities = $this->client->tesis->entities;
        $this->helper = new GeneralHelper();
    }


    public function dashboard()
    {
        return view('entities.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $mongo_start = microtime(true);
            $result_mongo = $this->entities->find([],['limit' => $qty]);
            $mongo_total = microtime(true) - $mongo_start;

            $mysql_start = microtime(true);
            $result_mysql = DB::table('entities')->limit($qty)->get();
            $mysql_total = microtime(true) - $mysql_start;

            $comparison = [
                'qty' => $qty,
                'mongo' => [
                    'time' => $mongo_total
                ],
                'mysql' => [
                    'time' => $mysql_total
                ],
                'data' => $qty,
            ];

            return response($comparison, 201);
        } else {
            $result = $this->entities->find()->toArray();
            $result = json_encode($result);

            return response($result, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;
        $random_data = isset($data['random_data']) ? $data['random_data'] : null;

        if ($qty){
            $mongo_objects = [];
            $mysql_objects = [];

            if ($random_data === 'true'){
                $mongo_objects = factory(MysqlEntity::class, 'mongo', $qty)->make()->toArray();
                foreach ($mongo_objects as &$mongo_object){
                    (new MongoEntity())->setRelationships($mongo_object);
                }

                $mysql_objects = factory(MysqlEntity::class, 'mysql', $qty)->make()->toArray();
            } else {
                $mongo_object = factory(MysqlEntity::class, 'mongo')->make()->toArray();
                $mysql_object = factory(MysqlEntity::class, 'mysql')->make()->toArray();
                for ($i=0; $i<$qty;$i++){
                    $mongo_objects[] = $mongo_object;
                    $mysql_objects[] = $mysql_object;
                }
            }
            $mongo_start = microtime(true);
            $result = $this->entities->insertMany($mongo_objects);
            $mongo_total = microtime(true) - $mongo_start;

            $mysql_start = microtime(true);
            DB::table('entities')->insert($mysql_objects);
            $mysql_total = microtime(true) - $mysql_start;

            $comparison = [
                'qty' => $qty,
                'mongo' => [
                    'time' => $mongo_total
                ],
                'mysql' => [
                    'time' => $mysql_total
                ],
                'data' => $result->getInsertedCount(),
            ];

            return response($comparison, 201);
        } else {
            (new MongoEntity())->setRelationships($data);
            $entity_id = $this->entities->insertOne($data)->getInsertedId();
            $entity = $this->entities->findOne(['_id' => new ObjectID($entity_id)]);
            $result = json_encode($entity);

            return response($result, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = $this->entities->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($entity);

        return response($result, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $mongo_object = factory(MysqlEntity::class, 'mongo')->make()->toArray();
            $mysql_object = factory(MysqlEntity::class, 'mysql')->make()->toArray();

            $start_id = $this->entities->find([],['limit' => 1])->toArray()[0]->_id;
            $end_id = $this->entities->find([], ['limit' => 1, 'skip' => ($qty-1)])->toArray()[0]->_id;

            $mongo_start = microtime(true);
            $result = $this->entities->updateMany(
                ['_id' => ['$gte' => $start_id, '$lte' => $end_id]],
                ['$set' => $mongo_object]
            );
            $mongo_total = microtime(true) - $mongo_start;

            $mysql_start = microtime(true);
            DB::table('entities')->where('id', '!=', 0)->limit($qty)->update($mysql_object);
            $mysql_total = microtime(true) - $mysql_start;

            $comparison = [
                'qty' => $qty,
                'mongo' => [
                    'time' => $mongo_total
                ],
                'mysql' => [
                    'time' => $mysql_total
                ],
                'data' => $result->getModifiedCount(),
            ];

            return response($comparison, 200);
        } else {
            $data = $request->all();
            (new MongoEntity())->setRelationships($data);
            $this->entities->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $data]
            );
            $entity = $this->entities->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($entity);

            return response($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $start_id = $this->entities->find([],['limit' => 1])->toArray()[0]->_id;
            $end_id = $this->entities->find([], ['limit' => 1, 'skip' => ($qty-1)])->toArray()[0]->_id;

            $mongo_start = microtime(true);
            $result = $this->entities->deleteMany(
                ['_id' => ['$gte' => $start_id, '$lte' => $end_id]]
            );
            $mongo_total = microtime(true) - $mongo_start;

            $mysql_start = microtime(true);
            DB::table('entities')->where('id', '!=', 0)->limit($qty)->delete();
            $mysql_total = microtime(true) - $mysql_start;

            $comparison = [
                'qty' => $qty,
                'mongo' => [
                    'time' => $mongo_total
                ],
                'mysql' => [
                    'time' => $mysql_total
                ],
                'data' => $result->getDeletedCount(),
            ];

            return response($comparison, 200);
        } else {
            $this->entities->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
