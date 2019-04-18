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
        $this->client = new Client(env('MONGODB_URL'));
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->index($qty, $request);

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
		$request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->store($qty, $request, MysqlCompany::class, new MongoCompany());

            return $result;
        } else {

            $this->helper->setRelationships($request, 'users', 'user_id');
            $this->helper->setRelationships($request, 'currencies', 'currencies');
            $this->helper->setRelationships($request, 'responsibilities', 'responsibility_id');
            $company_id = $this->companies->insertOne($request)->getInsertedId();
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty, $request, MysqlCompany::class);

            return $result;
        } else {
            $this->helper->setRelationships($request, 'users', 'user_id');
            $this->helper->setRelationships($request, 'currencies', 'currencies');
            $this->helper->setRelationships($request, 'responsibilities', 'responsibility_id');

            $this->companies->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->destroy($qty, $request);

            return $result;
        } else {
            $this->companies->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
