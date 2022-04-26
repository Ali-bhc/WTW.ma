<?php
namespace App\DAOs;

    use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Movies
{

    /**
     * Function takes id of movie and returns its genres
     */
    public static function getMovieGenresByMovieId($id)
    {
        $query = "match(movie:Movie) where ID(movie) = $id
                  match(genre:Genre)<-[:IN_GENRE]-(movie)
                  return genre.name as genre LIMIT 4";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns a random movie that contains a cover picture
     */
    public static function getRandomMovieWithCover(){
        $query = "Match(movie:Movie) where movie.cover is not null return count(movie) as nbr";
        $nbrMoviesWithCover = app(Neo4j::class)->run($query)[0]->get('nbr');

        $random = rand(0,$nbrMoviesWithCover-1);

        $query = "Match(movie:Movie) where movie.cover is not null
                    return movie SKIP $random LIMIT 1";

        return app(Neo4j::class)->run($query)[0]->get('movie');
    }

    /**
     * Function returns n highest rated movies
    */
    public static function getNHighestRatedMovies($n){

        $query = "Match(movie:Movie) return movie order by movie.imdbRating desc limit $n";

        return app(Neo4j::class)->run($query);
    }

    /**
     *  Function returns n most visited movies (trending)
    */
    public static function getNMostVisitedMovies($n){
        $query = "Match(movie:Movie) return movie order by movie.nbrVisits desc limit $n";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns n newest movies
    */
    public static function getNNewestMovies($n){
        $query = "Match(movie:Movie) return movie order by movie.year desc limit $n";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns 25 movies for n page
     */
    public static function getMoviesPage($n)
    {
        $nbr_movies= ($n-1)*28;
        $query = "Match(movie:Movie) return movie skip $nbr_movies limit 28;";
        return app(Neo4j::class)->run($query);
    }

    public static function getMoviesCount()
    {
        $query="Match(movie:Movie) return count(movie) as nbr";
        return app(Neo4j::class)->run($query)[0]->get('nbr');
    }
}
