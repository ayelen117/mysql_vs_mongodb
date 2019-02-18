<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use App\Models\Mysql\User as MysqlUser;
use App\Models\MongoDB\User as MongoUser;
use App\Services\ServiceCrud;

class UserController extends Controller
{
    public $client;
    public $users;
    public $serviceCrud;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URL'));
        $this->users = $this->client->tesis->users;
        $this->serviceCrud = new ServiceCrud('users');
    }

    public function dashboard()
    {
        return view('users.dashboard');
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
            $result = $this->users->find()->toArray();
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
            $result = $this->serviceCrud->store($qty, $random_data, MysqlUser::class, new MongoUser());

            return $result;
        } else {

            $user_id = $this->users->insertOne($data)->getInsertedId();
            $user = $this->users->findOne(['_id' => new ObjectID($user_id)]);
            $result = json_encode($user);

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
        $user = $this->users->findOne(['_id' => new ObjectID($id)]);
        $result = json_encode($user);

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
            $result = $this->serviceCrud->update($qty,  MysqlUser::class);

            return $result;
        } else {
            $this->users->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $data]
            );
            $user = $this->users->findOne(['_id' => new ObjectID($id)]);
            $result = json_encode($user);

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
            $this->users->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
