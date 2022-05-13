<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Actors
{

    /**
     * Function return n random popular actors
    */
    public static function getNRandomActors($n)
    {
        $random = rand(0,300);
        $query = "match(actor:Actor)-[:ACTED_IN]->(movie:Movie) where actor.poster is not null return actor, count(movie) as nbrMovies
                    order by nbrMovies desc skip $random limit $n";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns actors of the given movie
    */
    public static function getMovieActors($movieId){
        $query = "match(movie:Movie)<-[:ACTED_IN]-(actor:Person) where ID(movie) = $movieId return actor";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns similar Actors to the Actor given :
     * Actors that played the most with the given actor
     */
    public static function getNSimilarActors($actorID, $n){
        $query = "match(a:Actor) where ID(a) = $actorID
                    match(actor:Actor)-[r:ACTED_IN]->(m:Movie)<-[:ACTED_IN]-(a)
                    return actor , count(r) as CommonMovies order by CommonMovies desc LIMIT $n";
        return app(Neo4j::class)->run($query);
    }



}
