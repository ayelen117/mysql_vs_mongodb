<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;


class ResponsibilityController extends Controller
{
    public $client;
    public $responsibilities;

    public function __construct()
    {
        $this->client = new Client(config('database.mongodb.url'));
        $this->responsibilities = $this->client->tesis->responsibilities;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->responsibilities->find()->toArray();
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

        $responsibility_id = $this->responsibilities->insertOne($data)->getInsertedId();
        $responsibility = $this->responsibilities->findOne(['_id' => new ObjectID($responsibility_id)]);
        $result = json_encode($responsibility);

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
        $responsibility = $this->responsibilities->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($responsibility);

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
        $this->responsibilities->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $responsibility = $this->responsibilities->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($responsibility);

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
        $this->responsibilities->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
