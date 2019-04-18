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
        $this->client = new Client(env('MONGODB_URL'));
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->index($qty, $request);

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
		$request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->store($qty, $request, MysqlDocument::class, new MongoDocument());

            return $result;
        } else {

            $this->helper->setRelationships($request, 'users', 'author_id');
            $this->helper->setRelationships($request, 'companies', 'company_id');
            $this->helper->setRelationships($request, 'entities', 'entity_id');
            $this->helper->setRelationships($request, 'entities', 'seller_id');
            $this->helper->setRelationships($request, 'currencies', 'currency_id');
            $this->helper->setRelationships($request, 'receipts', 'receipt_id');
    //        $this->helper->setRelationships($request, 'details', 'details');
            $document_id = $this->documents->insertOne($request)->getInsertedId();
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty, $request, MysqlDocument::class);

            return $result;
        } else {
            $this->helper->setRelationships($request, 'users', 'author_id');
            $this->helper->setRelationships($request, 'companies', 'company_id');
            $this->helper->setRelationships($request, 'entities', 'entity_id');
            $this->helper->setRelationships($request, 'entities', 'seller_id');
            $this->helper->setRelationships($request, 'currencies', 'currency_id');
            $this->helper->setRelationships($request, 'receipts', 'receipt_id');
    //        $this->helper->setRelationships($request, 'details', 'details');
            $this->documents->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->destroy($qty, $request);

            return $result;
        } else {
            $this->documents->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
