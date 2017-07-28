<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Helpers\GeneralHelper;

class ProductController extends Controller
{
    public $client;
    public $products;
    public $helper;

    public function __construct()
    {
        $this->client = new Client();
        $this->products = $this->client->tesis->products;
        $this->helper = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->products->find()->toArray();
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
        $data = $this->helper->setRelationships($data, 'users', 'author_id');
        $data = $this->helper->setRelationships($data, 'categories', 'category_id');
        $data = $this->helper->setRelationships($data, 'taxes', 'tax_id');
        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');

        $product_id = $this->products->insertOne($data)->getInsertedId();
        $product = $this->products->findOne(['_id' => new ObjectID($product_id)]);
        $result = json_encode($product);

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
        $data = $request->all();
        $data = $this->helper->setRelationships($data, 'companies', 'company_id');
        $data = $this->helper->setRelationships($data, 'users', 'author_id');
        $data = $this->helper->setRelationships($data, 'categories', 'category_id');
        $data = $this->helper->setRelationships($data, 'taxes', 'tax_id');
        $data = $this->helper->setRelationships($data, 'currencies', 'currency_id');

        $this->products->updateOne(
            ['_id' => new ObjectID($id)],
            ['$set' => $data]
        );
        $product = $this->products->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($product);

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
        $this->products->deleteOne(['_id' => new ObjectID($id)]);

        return response()->json(['status' => 'success'], 200);
    }
}
