<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;


class ReceiptController extends Controller
{
    public $client;
    public $receipts;

    public function __construct()
    {
        $this->client = new Client(config('database.mongodb.url'));
        $this->receipts = $this->client->tesis->receipts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->receipts->find()->toArray();
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

        $receipt_id = $this->receipts->insertOne($data)->getInsertedId();
        $receipt = $this->receipts->findOne(['_id' => new ObjectID($receipt_id)]);
        $result = json_encode($receipt);

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
        $receipt = $this->receipts->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($receipt);

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
        $this->receipts->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $receipt = $this->receipts->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($receipt);

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
        $this->receipts->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
