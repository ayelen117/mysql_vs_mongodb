<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;
use App\Models\Mysql\Pricelist as MysqlPricelist;
use App\Models\MongoDB\Pricelist as MongoPricelist;
use App\Services\ServiceCrud;


class PricelistController extends Controller
{
    public $client;
    public $pricelists;
    public $helper;
    public $serviceCrud;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->pricelists = $this->client->tesis->pricelists;
        $this->helper = new GeneralHelper();
        $this->serviceCrud = new ServiceCrud('pricelists');
    }

    public function dashboard()
    {
        return view('pricelists.dashboard');
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
            $result = $this->pricelists->find()->toArray();
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
            $result = $this->serviceCrud->store($qty, $random_data, MysqlPricelist::class, new MongoPricelist());

            return $result;
        } else {
            $this->helper->setRelationships($data, 'companies', 'company_id');
            $pricelist_id = $this->pricelists->insertOne($data)->getInsertedId();
            $pricelist = $this->pricelists->findOne(['_id' => new ObjectID($pricelist_id)]);
            $result = json_encode($pricelist);

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
        $qty = isset($data['qty']) ? (int) $data['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty,  MysqlPricelist::class);

            return $result;
        } else {
            $this->helper->setRelationships($data, 'companies', 'company_id');
            $this->pricelists->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $data]
            );
            $pricelist = $this->pricelists->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($pricelist);

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
            $this->pricelists->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
