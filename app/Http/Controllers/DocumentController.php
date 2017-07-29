<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;

class DocumentController extends Controller
{
    public $client;
    public $documents;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->documents = $this->client->tesis->documents;
        $this->helper = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->documents->find()->toArray();
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

        $data = $this->helper->setRelationships($data, 'users', 'author_id');
        $data = $this->helper->setRelationships($data, 'companies', 'company_id');
        $data = $this->helper->setRelationships($data, 'entities', 'entity_id');
        $data = $this->helper->setRelationships($data, 'entities', 'seller_id');
        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');
        $data = $this->helper->setRelationships($data, 'receipts', 'receipt_id');
//        $data = $this->helper->setRelationships($data, 'details', 'details');
        $document_id = $this->documents->insertOne($data)->getInsertedId();
        $document = $this->documents->findOne(['_id' => new ObjectID($document_id)]);
        $result = json_encode($document);

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
        $document = $this->documents->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($document);

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
        $data = $this->helper->setRelationships($data, 'users', 'author_id');
        $data = $this->helper->setRelationships($data, 'companies', 'company_id');
        $data = $this->helper->setRelationships($data, 'entities', 'entity_id');
        $data = $this->helper->setRelationships($data, 'entities', 'seller_id');
        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');
        $data = $this->helper->setRelationships($data, 'receipts', 'receipt_id');
//        $data = $this->helper->setRelationships($data, 'details', 'details');
        $this->documents->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $document = $this->documents->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($document);

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
        $this->documents->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
