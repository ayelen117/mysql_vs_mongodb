<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;

class PricelistController extends Controller
{
    public $client;
    public $pricelists;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->pricelists = $this->client->tesis->pricelists;
        $this->helper = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->pricelists->find()->toArray();
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

        $data = $this->helper->setRelationships($data, 'companies', 'company_id');
        $pricelist_id = $this->pricelists->insertOne($data)->getInsertedId();
        $pricelist = $this->pricelists->findOne(['_id' => new ObjectID($pricelist_id)]);
        $result = json_encode($pricelist);

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
        $pricelist = $this->pricelists->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($pricelist);

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
        $data = $this->helper->setRelationships($data, 'companies', 'company_id');
        $this->pricelists->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $pricelist = $this->pricelists->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($pricelist);

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
        $this->pricelists->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
