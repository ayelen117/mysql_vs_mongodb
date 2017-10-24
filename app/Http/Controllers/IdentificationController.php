<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;


class IdentificationController extends Controller
{
    public $client;
    public $identifications;

    public function __construct()
    {
        $this->client = new Client();
        $this->identifications = $this->client->tesis->identifications;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->identifications->find()->toArray();
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

        $identification_id = $this->identifications->insertOne($data)->getInsertedId();
        $identification = $this->identifications->findOne(['_id' => new ObjectID($identification_id)]);
        $result = json_encode($identification);

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
        $identification = $this->identifications->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($identification);

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
        $this->identifications->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $identification = $this->identifications->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($identification);

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
        $this->identifications->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
