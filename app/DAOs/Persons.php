<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Persons
{
    /**
     * Function return Person with the given id
     */
    public static function getPersonById($id){
        $query = "match(person:Person) where ID(person) = $id return person";
        return app(Neo4j::class)->run($query)[0];
    }

    /**
     * Function returns number of movies of the given person (acted in)
    */
    public static function getNbrOfPersonActedInMovies($actorId){
        $query = "match(person:Person) where ID(person) = $actorId
                    match(person)-[:ACTED_IN]->(movie:Movie) return count(movie) as nbr";
        return app(Neo4j::class)->run($query)[0];
    }

    /**
     * Function returns number of movies of the given person (directed)
     */
    public static function getNbrOfPersonDirectedMovies($actorId){
        $query = "match(person:Person) where ID(person) = $actorId
                    match(person)-[:DIRECTED]->(movie:Movie) return count(movie) as nbr";
        return app(Neo4j::class)->run($query)[0];
    }






}
