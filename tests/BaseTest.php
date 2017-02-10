<?php

namespace tests;

use App;
use DB;
use Illuminate\Http\Response;
use JWTAuth;
use Log;

class BaseTest extends TestCase
{


    public function createUser($email)
    {

        //Borro usuario con el mail
        DB::table('users')->where('email', $email)->delete();
        $user             = new User();
        $user->email      = $email;
        $user->first_name = 'Example First Name';
        $user->last_name  = 'Example Last Name';
        $user->save();

        return $user->id;

    }

    public function createCompany($company_name, $user_id)
    {

        DB::table('companies')->where('name', $company_name)->delete();
        //Creo Compañía
        $company               = new Company();
        $company->name         = 'company_1';
        $company->user_id      = $user_id;
        $company->abbreviation = 'comp1';
        $company->description  = 'description';
        $company->save();

        return $company->id;
    }

    public function createRol($rol_name, $company_id)
    {

        //Borro los roles
        DB::table('roles')->where('name', $rol_name)->delete();
        //Creo un rol nuevo
        $rol              = new Role();
        $rol->name        = $rol_name;
        $rol->slug        = $rol_name;
        $rol->description = $rol_name;
        $rol->company_id  = $company_id;
        $rol->save();
        exit();

        return $rol->id;
    }

    public function createPermission($name, $slugs = [])
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->where('name', $name)->delete();
        DB::table('role_user')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //Creo los permisos
        $permission = new Permission();
        $permission->create([
            'name' => $name,
            'slug' => $slugs,
            'description' => 'manage user permissions'
        ]);

        return true;


    }

    public function assignPermisions($company_id, $user_id, $rol_id, $permission_name)
    {

        $rol  = Role::find($rol_id);
        $user = User::find($user_id);
        //Asigno roles al usuario
        $user->assignRole($rol_id, $company_id);
        //Asigno permisos al rol en particular
        $rol->assignPermission($permission_name, $company_id);

        return true;
    }

    public function setToken($email, $password = 'multinexo')
    {
        $array    = [
            'email' => $email,
            'password' => $password
        ];
        $response = $this->call('POST', route('authenticate'), $array, [], [], ['application/x-www-form-urlencoded']);

        $content = str_replace('"', '', $response->getContent());

        $user = User::where('email', $email)->first();

        //Seteo la variable user en el contenedor de laravel (ya que con la linea de arriba lo deberia hacer, pero como
        //estamos con unittest no lo hace)
        App::bind('user', function () use ($user) {
            return $user;
        });
        $this->token = $content;
    }

    public function getToken($email, $password = 'secret')
    {
        $array    = [
            'email' => $email,
            'password' => $password
        ];
        $response = $this->call('POST', route('authenticate'), $array, [], [], ['application/x-www-form-urlencoded']);

        $content = str_replace('"', '', $response->getContent());

        $user = User::where('email', $email)->first();

        //Seteo la variable user en el contenedor de laravel (ya que con la linea de arriba lo deberia hacer, pero como
        //estamos con unittest no lo hace)
        App::bind('user', function () use ($user) {
            return $user;
        });
        $this->token = $content;

        return $content;
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return Response
     */
    protected function callGet($url, array $parameters = [])
    {
        return $this->call('GET', $url, $parameters, [], [], $this->getServerArray());
    }

    /**
     * @param string $url
     *
     * @return Response
     */
    protected function callDelete($url)
    {
        return $this->call('DELETE', $url, [], [], [], $this->getServerArray());
    }

    /**
     * @param string $url
     * @param string $content
     *
     * @return Response
     */
    protected function callPost($url, $content)
    {
        return $this->call('post', $url, $content, [], [], $this->getServerArray());
    }

    /**
     * @param string $url
     * @param string $content
     *
     * @return Response
     */
    protected function callPatch($url, $content)
    {
        return $this->call('PATCH', $url, $content, [], [], $this->getServerArray(), []);
    }

    /**
     * @param string $url
     * @param string $content
     *
     * @return Response
     */
    protected function callPut($url, $content)
    {
        return $this->call('PUT', $url, $content, [], [], $this->getServerArray(), []);
    }

    private function getServerArray()
    {
        $server = [
            'HTTP_Authorization' => 'Bearer ' . $this->token,
        ];

        return $server;
    }

    public function test()
    {
        $this->assertEquals(1, 1);
    }

    public function debug($test)
    {

        if ($this->response->getStatusCode() == 400) {
            Log::info('######### Fallo: @$' . $test);
            Log::debug($this->response->getContent());
            Log::info('######################################################################################');
        }
    }

}
