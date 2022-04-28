<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Directors
{

    /**
     * function return directors of the given movie
    */
    public static function getMovieDirectors($movieID){
        $query = "match(movie:Movie)<-[:DIRECTED]-(director:Director) where ID(movie) = $movieID return director";
        return app(Neo4j::class)->run($query);
    }


}
