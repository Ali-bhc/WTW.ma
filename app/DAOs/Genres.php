<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Genres
{

    /**
     * Function returns all genres
    */
    public static function allGenres(){
        $query = "match(genre:Genre) where genre.img is not null return genre";
        return app(Neo4j::class)->run($query);
    }

        /**
         * Function returns all genres with number of movies in each genre
         */
    public static function allGenresWithNbrOfMovies(){
        $query = "match(genre:Genre)<-[:IN_GENRE]-(movie:Movie) where genre.img is not null
                    return genre, count(movie) as nbrMovies";
        return app(Neo4j::class)->run($query);
    }

    /**
     * function returns number of movies by genre id
    */
    public static function numberOfMoviesByGenre($genreID)
    {
        $query = "match(genre:Genre)<-[:IN_GENRE]-(movie:Movie) where ID(genre) = $genreID return count(movie) as nbr";
        $nbr = app(Neo4j::class)->run($query)[0]->get('nbr');
        return $nbr;
    }


}
