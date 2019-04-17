<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;
use App\Models\Mysql\Product as MysqlProduct;
use App\Models\MongoDB\Product as MongoProduct;
use App\Services\ServiceCrud;

class ProductController extends Controller
{
    public $client;
    public $products;
    public $helper;
    public $serviceCrud;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->products = $this->client->tesis->products;
        $this->helper = new GeneralHelper();
        $this->serviceCrud = new ServiceCrud('products');
    }

    public function dashboard()
    {
        return view('products.dashboard');
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
            $result = $this->products->find()->toArray();
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
            $result = $this->serviceCrud->store($qty, $request, MysqlProduct::class, new MongoProduct());

            return $result;
        } else {

            $this->helper->setRelationships($request, 'companies', 'company_id');
            $this->helper->setRelationships($request, 'users', 'author_id');
            $this->helper->setRelationships($request, 'categories', 'category_id');
            $this->helper->setRelationships($request, 'taxes', 'tax_id');
            $this->helper->setRelationships($request, 'currencies', 'currency_id');
    
            $product_id = $this->products->insertOne($request)->getInsertedId();
            $product = $this->products->findOne(['_id' => new ObjectID($product_id)]);
            $result = json_encode($product);
    
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
        $product = $this->products->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($product);

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
            $result = $this->serviceCrud->update($qty, $request, MysqlProduct::class);

            return $result;
        } else {
            $this->helper->setRelationships($request, 'companies', 'company_id');
            $this->helper->setRelationships($request, 'users', 'author_id');
            $this->helper->setRelationships($request, 'categories', 'category_id');
            $this->helper->setRelationships($request, 'taxes', 'tax_id');
            $this->helper->setRelationships($request, 'currencies', 'currency_id');
    
            $this->products->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
            );
            $product = $this->products->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($product);
    
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
            $this->products->deleteOne(['_id' => new ObjectID($id)]);
    
            return response()->json(['status' => 'success'], 200);
        }
    }
}
