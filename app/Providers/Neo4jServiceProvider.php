<?php

namespace App\Providers;

use \Laudis\Neo4j\Bolt\Session;
use Illuminate\Support\ServiceProvider;
use \Laudis\Neo4j\ClientBuilder;
use \Laudis\Neo4j\Authentication\Authenticate;

class Neo4jServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Session::class, function($app){
            return $this->getClient();
        });
    }

    protected function getClient(){

        $password = config('database.connections.neo4j.password');
        $username = config('database.connections.neo4j.username');
        $protocol = config('database.connections.neo4j.protocol');

        $auth = Authenticate::basic($username, $password);

        $client = ClientBuilder::create()->withDriver($protocol, $this->getConnectionString(), $auth)->build();

        return $client;
    }

    protected function getConnectionString(){
        return sprintf(
            '%s://%s:%s',
            config('database.connections.neo4j.protocol'),
            config('database.connections.neo4j.host'),
            config('database.connections.neo4j.port')
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
