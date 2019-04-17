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
     * Devuelve una lista de usuarios
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
		$request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->store($qty, $request, MysqlUser::class, new MongoUser());

            return $result;
        } else {

            $user_id = $this->users->insertOne($request)->getInsertedId();
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->update($qty, $request, MysqlUser::class);

            return $result;
        } else {
            $this->users->updateOne(
                ['_id' => new ObjectID($id)],
                ['$set' => $request]
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
        $request = $request->all();
        $qty = isset($request['qty']) ? (int) $request['qty'] : null;

        if ($qty){
            $result = $this->serviceCrud->destroy($qty, $request);

            return $result;
        } else {
            $this->users->deleteOne(['_id' => new ObjectID($id)]);

            return response()->json(['status' => 'success'], 200);
        }
    }
}
