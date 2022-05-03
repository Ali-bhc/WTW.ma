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
     * Function returns 28 movies for n page
     */
    public static function getMoviesPage( $n)
    {
        $nbr_movies=($n-1)*28;
        $query = "Match(movie:Movie) return movie skip $nbr_movies limit 28";
        return app(Neo4j::class)->run($query);
    }
    /**
     * Function returns 28 movies for n page
     */
    public static function getMoviesbyFilter($page,$search, $genre , $rating ,$year , $language , $orderby)
    {
        // $nbr_movies returns the movies number which would skip for a page
        $nbr_movies= ($page-1)*28;
        $query = "match(genre:Genre)<-[:IN_GENRE]-(movie:Movie) ";

        //searching
        if ($search != "" && $search != "all")
            $query .= " where movie.title contains '$search' and ";
        else
            $query .= "where ";


        // filter by genre
        if ($genre != "" && $genre !='all')
            $query .= "genre.name='$genre' and ";

        //filter by imdbrating
        if ( $rating != "" && $rating != "all")
            $query .= "movie.imdbRating > $rating and ";

        //filter by year
        if ( $year != "" && $year !="all") {

            $query .= substr($year,5,4)."< movie.year <".substr($year,0,4)." and ";
        }

        //filter by language
        if ($language != "" && $language != "all")
            $query .= "movie.languages[0] = '$language' and ";


        $query .= "movie.poster is not null return distinct movie ";

        if ($orderby != "" && $orderby != "all") {
            $query .= "order by ";
            switch ($orderby) {
                case "Latest":
                    $query .= " movie.year desc ";
                    break;
                case "Oldest":
                    $query .= " movie.year ";
                    break;
                case "Highest rating":
                    $query .= " movie.ImdbRating desc ";
                    break;
                case "Lowest rating":
                    $query .= " movie.ImdbRating ";
                    break;
                case "Visits number":
                    $query .= " movie.nbrVisits ";
                    break;
                case "RT Audiance":
                    $query .= " movie.runtime ";
                    break;
                case "revenue":
                    $query .= " movie.revenue ";
                    break;
                case "Alphabitical":
                    $query .= " movie.title ";
                    break;
            }
        }
        $query .= "skip $nbr_movies limit 28";
        //dd($query);
        return app(Neo4j::class)->run($query);
    }


    /**
     * function returns all languages
     */
    public static function getAllLanguages()
    {
        $query = "match (movie:Movie) where movie.languages[0] is not null  return distinct  movie.languages[0] as lang";
        return app(Neo4j::class)->run($query);

    }

    /**
     * function returns number of all movies filtred or not filtred
     */
    public static function getMoviesCount($search, $genre , $rating ,$year , $language)

    {
        $query = "match(genre:Genre)<-[:IN_GENRE]-(movie:Movie) ";

        //searching
        if ($search != "" && $search != "all")
            $query .= " where movie.title contains '$search' and ";
        else
            $query .= "where ";


        // filter by genre
        if ($genre != "" && $genre !='all')
            $query .= "genre.name='$genre' and ";

        //filter by imdbrating
        if ( $rating != "" && $rating != "all")
            $query .= "movie.imdbRating > $rating and ";

        //filter by year
        if ( $year != "" && $year !="all") {

            $query .= substr($year,5,4)."< movie.year <".substr($year,0,4)." and ";
        }

        //filter by language
        if ($language != "" && $language != "all")
            $query .= "movie.languages[0] = '$language' and ";


        $query .= "movie.poster is not null return distinct count(movie) as nbr";
        //dd($query);
        return app(Neo4j::class)->run($query)[0]->get('nbr');
    }
}
