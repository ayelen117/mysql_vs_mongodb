<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
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
//            'HTTP_Authorization' => 'Bearer ' . $this->token,
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

    public function logTime($initial){
        \Illuminate\Support\Facades\Log::info('Time: ' . round((microtime(true) - $initial), 3));
    }
}
