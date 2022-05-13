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


    /**
     * Function returns n random directors
     */
    public static function getNRandomDirectors($n){
        $query = "Match(director:Director) return count(director) as nbr";
        $nbrDirectors  = app(Neo4j::class)->run($query)[0]->get('nbr');

        $random = rand(0, $nbrDirectors-1);

        $query = "Match(director:Director) return director SKIP $random LIMIT $n";
        return app(Neo4j::class)->run($query);
    }



}
