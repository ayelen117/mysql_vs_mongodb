<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;

class TransactionController extends Controller
{
    public $client;
    public $transactions;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->transactions = $this->client->tesis->transactions;
        $this->helper = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->transactions->find()->toArray();
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

        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');
        $transaction_id = $this->transactions->insertOne($data)->getInsertedId();
        $transaction = $this->transactions->findOne(['_id' => new ObjectID($transaction_id)]);
        $result = json_encode($transaction);

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
        $transaction = $this->transactions->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($transaction);

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
        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');
        $this->transactions->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $transaction = $this->transactions->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($transaction);

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
        $this->transactions->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
