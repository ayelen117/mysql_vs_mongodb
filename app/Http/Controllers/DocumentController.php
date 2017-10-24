<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;
use App\Models\Mysql\Document as MysqlDocument;
use App\Models\MongoDB\Document as MongoDocument;
use App\Services\ServiceCrud;

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
        $this->serviceCrud = new ServiceCrud('documents');
    }

    public function dashboard()
    {
        return view('documents.dashboard');
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
            $result = $this->documents->find()->toArray();
            $result = json_encode($result);

            return response($result, 200);
        }
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
            $result = $this->serviceCrud->store($qty, $random_data, MysqlDocument::class, new MongoDocument());

            return $result;
        } else {

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
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty,  MysqlDocument::class);

            return $result;
        } else {
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
    }

    /**
     * Remove the specified resource from storage.
     *
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
            $this->documents->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
