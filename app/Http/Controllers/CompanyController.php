<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Models\Mysql\Company as MysqlCompany;
use App\Models\MongoDB\Company as MongoCompany;
use App\Services\ServiceCrud;

class CompanyController extends Controller
{
    public $client;
    public $companies;
    public $serviceCrud;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->companies = $this->client->tesis->companies;
        $this->helper = new GeneralHelper();
        $this->serviceCrud = new ServiceCrud('companies');
    }

    public function dashboard()
    {
        return view('companies.dashboard');
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
            $result = $this->companies->find()->toArray();
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
            $result = $this->serviceCrud->store($qty, $random_data, MysqlCompany::class, new MongoCompany());

            return $result;
        } else {

            $data = $this->helper->setRelationships($data, 'users', 'user_id');
            $data = $this->helper->setRelationships($data, 'currencies', 'currencies');
            $data = $this->helper->setRelationships($data, 'responsibilities', 'responsibility_id');
            $company_id = $this->companies->insertOne($data)->getInsertedId();
            $company = $this->companies->findOne(['_id' => new ObjectID($company_id)]);
            $result = json_encode($company);

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
        $company = $this->companies->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($company);

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
            $result = $this->serviceCrud->update($qty,  MysqlCompany::class);

            return $result;
        } else {
            $data = $this->helper->setRelationships($data, 'users', 'user_id');
            $data = $this->helper->setRelationships($data, 'currencies', 'currencies');
            $data = $this->helper->setRelationships($data, 'responsibilities', 'responsibility_id');

            $this->companies->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $data]
            );
            $company = $this->companies->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($company);

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
            $this->companies->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
