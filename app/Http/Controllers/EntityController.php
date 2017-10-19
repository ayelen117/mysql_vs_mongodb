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
        $this->client = new Client();
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
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->index($qty);

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
        $data = $request->all();
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;
        $random_data = isset($data['random_data']) ? $data['random_data'] : null;

        if ($qty){
            $result = $this->serviceCrud->store($qty, $random_data, MysqlEntity::class, new MongoEntity());

            return $result;
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
            $result = $this->serviceCrud->update($qty,  MysqlEntity::class);

            return $result;
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
            $result = $this->serviceCrud->destroy($qty);

            return $result;
        } else {
            $this->entities->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
