<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost/test/cl/Docs/projects/beeryde/public/index.php';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Setup DB before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        //$this->app['config']->set('database.default', 'sqlite');
        //$this->app['config']->set('database.connections.sqlite.database', ':memory:');
        //$this->migrate();
    }

    protected function prepareTheDatabase()
    {
        Artisan::call("migrate");

        /* vendor migrations */

        $packages = array(
            "lucadegasperi/oauth2-server-laravel",
        );

        foreach ($packages as $packageName) {
            Artisan::call("migrate", array("--package" => $packageName, "--env" => "testing"));
        }

        /* do seeding */

        $seeders = array(
            "OAuthTestSeeder",
        );

        foreach ($seeders as $seedClass) {
            Artisan::call("db:seed", array("--class" => $seedClass));
        }
    }

    protected function prepAothServer($verb, &$parameters)
    {
        /* sign the request */
        $parameters['access_token'] = OAuthTestSeeder::ACCESS_TOKEN;

        $request = MockRequest::newRequest($verb, $parameters);
        ResourceServer::setRequest($request);
    }
}
