<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;

class InventoryController extends Controller
{
    public $client;
    public $inventories;
    public $helper;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->inventories = $this->client->tesis->inventories;
        $this->helper = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->inventories->find()->toArray();
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

        $this->helper->setRelationships($data, 'products', 'product_id');
        $inventory_id = $this->inventories->insertOne($data)->getInsertedId();
        $inventory = $this->inventories->findOne(['_id' => new ObjectID($inventory_id)]);
        $result = json_encode($inventory);

        return response($result, 201);
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
        $inventory = $this->inventories->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($inventory);

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
        $this->helper->setRelationships($data, 'products', 'product_id');
        $this->inventories->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $inventory = $this->inventories->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($inventory);

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
        $this->inventories->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
