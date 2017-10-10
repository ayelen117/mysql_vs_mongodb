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
        } else {}

        $result = $this->entities->find()->toArray();
        $result = json_encode($result);

        return response($result, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            if ($random_data){
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        (new MongoEntity())->setRelationships($data);
        $this->entities->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $entity = $this->entities->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($entity);

        return response($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entities->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
