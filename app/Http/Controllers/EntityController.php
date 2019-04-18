<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Models\Mysql\Entity as MysqlEntity;
use App\Models\MongoDB\Entity as MongoEntity;
use App\Services\ServiceCrud;

class EntityController extends Controller
{
    public $client;
    public $entities;
    public $serviceCrud;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->entities = $this->client->tesis->entities;
        $this->serviceCrud = new ServiceCrud('entities');
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->index($qty, $request);

            return $result;
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->store($qty, $request, MysqlEntity::class, new MongoEntity());

            return $result;
        } else {
            (new MongoEntity())->setRelationships($request);
            $entity_id = $this->entities->insertOne($request)->getInsertedId();
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty, $request, MysqlEntity::class);

            return $result;
        } else {
            $request = $request->all();
            (new MongoEntity())->setRelationships($request);
            $this->entities->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->destroy($qty, $request);

            return $result;
        } else {
            $this->entities->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
