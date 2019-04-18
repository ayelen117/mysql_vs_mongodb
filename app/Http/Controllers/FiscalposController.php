<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;
use App\Models\Mysql\Fiscalpos as MysqlFiscalpos;
use App\Models\MongoDB\Fiscalpos as MongoFiscalpos;
use App\Services\ServiceCrud;

class FiscalposController extends Controller
{
    public $client;
    public $fiscalpos;
    public $helper;
    public $serviceCrud;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->fiscalpos = $this->client->tesis->fiscalpos;
        $this->helper = new GeneralHelper();
        $this->serviceCrud = new ServiceCrud('fiscalpos');
    }

    public function dashboard()
    {
        return view('fiscalpos.dashboard');
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
            $result = $this->fiscalpos->find()->toArray();
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
            $result = $this->serviceCrud->store($qty, $request, MysqlFiscalpos::class, new MongoFiscalpos());

            return $result;
        } else {

            $this->helper->setRelationships($request, 'companies', 'company_id');
            $fiscalpos_id = $this->fiscalpos->insertOne($request)->getInsertedId();
            $fiscalpos = $this->fiscalpos->findOne(['_id' => new ObjectID($fiscalpos_id)]);
            $result = json_encode($fiscalpos);

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
        $fiscalpos = $this->fiscalpos->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($fiscalpos);

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
            $result = $this->serviceCrud->update($qty, $request, MysqlFiscalpos::class);

            return $result;
        } else {
            $this->helper->setRelationships($request, 'companies', 'company_id');
            $this->fiscalpos->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
            );
            $fiscalpos = $this->fiscalpos->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($fiscalpos);
    
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
            $this->fiscalpos->deleteOne(['_id' => new ObjectID($id)]);
    
            return response()->json(['status' => 'success'], 200);
        }
    }
	
	public function models()
	{
		return view('other_models.dashboard');
	}
}
