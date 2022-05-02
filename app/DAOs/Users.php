<?php
namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Users{

    /**
     * Function creates user node in neo4j database
     * @param (user data)
     * @return void true if the node successfully created, false otherwise
    */
    public static function createUserNode($id, $username, $name, $email, $img){
        $name = addslashes($name);
        $query = "create (user:User {userId : $id, username: '$username', name: '$name',  email: '$email', img: '$img' }) ";
        echo $query;
        app(Neo4j::class)->run($query);
    }


    /**
     * Dorp all User nodes
     */
    public static function dropAllUserNodes(){
        $query = "match(user: User) detach delete user";
        app(Neo4j::class)->run($query);
    }

    /**
     * function takes user_id and movie_id
     * when a user bookmarked a movie
    */
    public static function bookmark($userId, $movieId){
        $query = "match(user:User) where user.userId = $userId
                match(movie:Movie) where ID(movie) = $movieId
                create (user)-[:BOOKMARKED]->(movie)
                return user, movie";

        app(Neo4j::class)->run($query);
    }


    /**
     * Function takes un-bookmark a movie from a user
     */
    public static function unBookmark($userId, $movieId){
        $query = "match(user:User) where user.userId = $userId
                match(movie:Movie) where ID(movie) = $movieId
                match (user)-[r:BOOKMARKED]->(movie)
                delete r";
        app(Neo4j::class)->run($query);
    }

        /**
     * checks if a movie if is bookmarked by a user
     * @params $userId, $movieId
     * @returns boolean
    */
    public static function isBookmarked($userId, $movieId){
        $query = "match(user:User) where user.userId = $userId
                match(movie:Movie) where ID(movie) = $movieId
                return Exists((user)-[:BOOKMARKED]->(movie)) as isBookmarked";

        $results = app(Neo4j::class)->run($query);
        if(count($results) > 0)
            return $results[0]->get('isBookmarked');
        return false;
    }


}
