<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Actors
{
    public static function getNRandomActors($n)
    {
        $random = rand(0,300);
        $query = "match(actor:Actor)-[:ACTED_IN]->(movie:Movie) where actor.poster is not null return actor, count(movie) as nbrMovies
                    order by nbrMovies desc skip $random limit $n";

        return app(Neo4j::class)->run($query);
    }
}
