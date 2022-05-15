<?php
namespace App\DAOs;

    use App\Providers\Neo4jServiceProvider;
    use \Laudis\Neo4j\Bolt\Session as Neo4j;
    use Laudis\Neo4j\Client;

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
     * Function returns movie of the given id
    */
    public static function getMovieById($id){
        $query = "match(movie:Movie) where ID(movie) = $id return movie";
        return app(Neo4j::class)->run($query)[0];
    }

    /**
     * Function increments number of visits of the given movie
    */
    public static function incrementNbrVisits($movieId){
        $query = "match(movie:Movie) where ID(movie) = $movieId set movie.nbrVisits = movie.nbrVisits+1;";
        app(Neo4j::class)->run($query);
    }

    /**
     * Function returns n similar movies to the given movie id,
     * the recommendations based on the number of actors, genres and directors they have in common
    */
    public static function getNSimilarMovies($movieId, $n){
        $query = "MATCH (m:Movie) WHERE ID(m) = $movieId
                MATCH (m)-[:IN_GENRE]->(g:Genre)<-[:IN_GENRE]-(rec:Movie)
                WITH m, rec, COUNT(*) AS gs
                OPTIONAL MATCH (m)<-[:ACTED_IN]-(a:Actor)-[:ACTED_IN]->(rec)
                WITH m, rec, gs, COUNT(a) AS as
                OPTIONAL MATCH (m)<-[:DIRECTED]-(d:Director)-[:DIRECTED]->(rec)
                WITH m, rec, gs, as, COUNT(d) AS ds
                RETURN rec AS movie, (5*gs)+(3*as)+(4*ds) AS score ORDER BY score DESC LIMIT $n";
        return app(Neo4j::class)->run($query);
    }

    /**
     * Function returns all movies of the given person (acted in)
    */
    public static function getAllPersonActedInMovies($personId){
        $query = "match(person:Person) where ID(person) = $personId
                    match(person)-[:ACTED_IN]->(movie:Movie)
                    return movie order by movie.year desc";
        return app(Neo4j::class)->run($query);
    }

        /**
         * Function returns all movies of the given person (Directed by)
         */
        public static function getAllPersonDirectedMovies($personId){
            $query = "match(person:Person) where ID(person) = $personId
                    match(person)-[:DIRECTED]->(movie:Movie)
                    return movie";
            return app(Neo4j::class)->run($query);
        }




        /**
         * get recommended movies for the user passed in argument
         * Personalized Recommendations Based on Genres
            Recommend movies similar to those the user has already watched
        */
        public static function getNRecommendedMovies($userId, $n){
            $query = "MATCH (u:User {userId: $userId})-[r:BOOKMARKED]->(m:Movie),
                      (m)-[:IN_GENRE]->(g:Genre)<-[:IN_GENRE]-(rec:Movie)
                    WHERE NOT EXISTS( (u)-[:BOOKMARKED]->(rec) )
                    WITH rec, [g.name, COUNT(*)] AS scores
                    RETURN rec as movie,
                    COLLECT(scores) AS scoreComponents,
                    REDUCE (s=0,x in COLLECT(scores) | s+x[1]) AS score
                    ORDER BY score DESC LIMIT $n";

            return app(Neo4j::class)->run($query);
        }



        /**
         * Get all movies bookmarked by a user
        */
        public static function getAllBookmarkedMovies($userId){
            $query = "Match(user:User {userId: $userId})-[:BOOKMARKED]->(movie:Movie) return movie";
            return app(Neo4j::class)->run($query);
        }


        public static function getMoviesbyFilter($page,$search, $genre , $rating ,$year , $language , $orderby)
        {
            // $nbr_movies returns the movies number which would skip for a page
            $nbr_movies= ($page-1)*28;
            $query = "match (movie:Movie) ";

            // filter by genre
            if ($genre != "" && $genre !='all')
                $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
            else
                $query .= "where ";

            //searching
            if ($search != "" && $search != "all")
                $query .= "toLower(movie.title) contains toLower('$search') and ";



            //filter by imdbrating
            if ( $rating != "" && $rating != "all")
                $query .= "movie.imdbRating > $rating and ";

            //filter by year
            if ( $year != "" && $year !="all") {
                if ($year =="2022")
                    $query.=" movie.year =".substr($year,0,4)." and ";
                elseif ($year == "older") {
                    $query .= "movie.year < 2000 and ";
                }
                else{
                    $query .= substr($year,5,4)."<= movie.year <=".substr($year,0,4)." and ";
                }
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
            $query = "match(movie:Movie)";

            // filter by genre
            if ($genre != "" && $genre !='all')
                $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
            else
                $query .= "where ";

            //searching
            if ($search != "" && $search != "all")
                $query .= "toLower(movie.title) contains toLower('$search') and ";


            //filter by imdbrating
            if ( $rating != "" && $rating != "all")
                $query .= "movie.imdbRating > $rating and ";

            //filter by year
            if ( $year != "" && $year !="all") {
                if ($year =="2022")
                    $query.=" movie.year =".substr($year,0,4)." and ";
                elseif ($year == "older") {
                    $query .= "movie.year < 2000 and ";
                }
                else
                $query .= substr($year,5,4)."<= movie.year <=".substr($year,0,4)." and ";
            }

            //filter by language
            if ($language != "" && $language != "all")
                $query .= "movie.languages[0] = '$language' and ";


            $query .= "movie.poster is not null return count(distinct movie) as nbr";
            //dd($query);
            return app(Neo4j::class)->run($query)[0]->get('nbr');
        }


}
