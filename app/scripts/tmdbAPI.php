<?php

namespace App\scripts;
use App\DAOs\Persons;
use Laudis\Neo4j\Types\Date;
use Bolt\Bolt;
use DateTimeImmutable;
use Imdb\Person;
use \Laudis\Neo4j\Bolt\Session as Neo4j;

use App\DAOs\Movies;
use Illuminate\Support\Facades\Http;
use Imdb\Title;

// pictures are sous form : http://image.tmdb.org/t/p/size(w185)/path

class tmdbAPI{

    public static function TestApiGet($movieId)
    {

        $urlMovie = "https://api.themoviedb.org/3/movie/$movieId?api_key=d339ae14076fb64b7c0193668edc86e7";
        $urlMoviePersons = "https://api.themoviedb.org/3/movie/429/credits?api_key=d339ae14076fb64b7c0193668edc86e7";
        $response = Http::get($urlMovie);


        /*Creating movie Node*/

        // budget
        $movie['budget'] = $response['budget'];

        // countries
        $movie['countries'] = array();
        foreach($response['production_countries'] as $country)
        {
            array_push($movie['countries'] ,$country['name']);
        }

        // imdbId
        $movie['imdbId'] = $response['imdb_id'];

        // imdbRating
        $imdbMovie = new Title($movie['imdbId']);

        $movie['imdbRating'] = $imdbMovie->rating();

        // imdbVotes
        $movie['imdbVotes'] = $imdbMovie->votes();

        // languages
        $movie['languages'] = $imdbMovie->languages();

        // nbr visits
        $movie['nbrVisits'] = 0;

        // plot
        $movie['plot'] = $imdbMovie->plotoutline();

        // released Date
        $movie['released'] = $imdbMovie->releaseInfo()[0]['year'] . '-' . $imdbMovie->releaseInfo()[0]['month'] . '-' . $imdbMovie->releaseInfo()[0]['day'];

        // revenue
        $movie['revenue'] = $response['revenue'];

        // runtime
        $movie['runtime'] = $response['runtime'];

        // title
        $movie['title'] = $response['title'];

        // tmdbid
        $movie['tmdbId'] = $response['id'];

        // url imdb
        $movie['url'] = $imdbMovie->main_url();

        // year
        $movie['year'] = intval($imdbMovie->year());

        // poster
        $movie['poster'] =  "https://image.tmdb.org/t/p/w1280" . $response['poster_path'];





        /* Movie Genres : */
        $movieGenres = array();
        foreach ($response['genres'] as $genre){
            array_push($movieGenres, $genre['name']);
        }


        /* Actors of the given movie */
        $movieActors = array();
        $i = 0;
        foreach ($imdbMovie->actor_stars() as $actor_star)
        {
            if($i >= 6)
                break;

            $actor = new Person($actor_star['imdb']);
            $movieActors[$i] = array();
            $movieActors[$i]['bio'] = count($actor->bio()) > 0 ? strlen($actor->bio()[0]['desc']) > 500 ? substr($actor->bio()[0]['desc'], 0, 500) . '...': $actor->bio()[0]['desc'] : "";
            $movieActors[$i]['born'] = $actor->born()['year'] . '-' . date("m", strtotime($actor->born()['month'])) . '-' . $actor->born()['day'];
            $movieActors[$i]['bornIn'] = $actor->born()['place'];
            $movieActors[$i]['imdbId'] = $actor->imdbid();
            $movieActors[$i]['name'] = $actor->name();
            $movieActors[$i]['url'] = $actor->main_url();
            $movieActors[$i]['poster'] = $actor->photo();
            if(count($actor->died()) > 0){
                $movieActors[$i]['died'] = $actor->died()['year'] . date("m", strtotime($actor->died()['month'])) . '-' . $actor->died()['day'];
            }
            $i++;
        }

        /*Directors of the given movie */
        $movieDirectors = array();
        foreach ($imdbMovie->director() as $item){

            $director = new Person($item['imdb']);
            $movieDirectors[$i] = array();
            $movieDirectors[$i]['bio'] = count($director->bio()) > 0 ? strlen($director->bio()[0]['desc']) > 500 ? substr($director->bio()[0]['desc'], 0, 500) . '...': $director->bio()[0]['desc'] : "";
            $movieDirectors[$i]['born'] = $director->born()['year'] . '-' . date("m", strtotime($director->born()['month'])) . '-' . $director->born()['day'];
            $movieDirectors[$i]['bornIn'] = $director->born()['place'];
            $movieDirectors[$i]['imdbId'] = $director->imdbid();
            $movieDirectors[$i]['name'] = $director->name();
            $movieDirectors[$i]['url'] = $director->main_url();
            $movieDirectors[$i]['poster'] = $director->photo();
            if(count($director->died()) > 0){
                $movieDirectors[$i]['died'] = $director->died()['year'] . '-' . date("m", strtotime($director->died()['month'])) . '-' . $director->died()['day'];
            }
        }




        /*Start creating nodes and relationships*/
        $isMovieExist = Movies::isExistByTitle($movie['title']);

        // if movie doesn't exist
        if(!$isMovieExist){

            // creating movie node
            $query = "create(movie:Movie { ";
            foreach($movie as $key => &$value)
            {
                if(!is_array($value))
                {
                    $query .= $key . ' : ';
                    if(is_string($value))
                    {
                        $value = addslashes($value);

                        $query .=  "'" . $value . "'";
                        if($key !== array_key_last($movie))
                            $query .=  ",";
                    }
                    else
                    {

                        $query .= $value ;
                        if($key !== array_key_last($movie))
                            $query .= ',';

                    }
                }
                else
                {
                    $query .= $key . ': [ ';
                    foreach ($value as $key2 => &$item)
                    {
                        $item = addslashes($item);
                        $query .= "'" . $item . "'";
                        if($key2 !== array_key_last($value))
                            $query .= ',';
                    }
                    $query .= "]";
                    if($key !== array_key_last($movie))
                        $query .= ',';
                }
            }
            $query .= "})\n";
            app(Neo4j::class)->run($query);
        }



        // linking movie with genres
        unset($value);
        foreach ($movieGenres as $key => $value){
            $query = "MATCH(movie:Movie {title : '"  . $movie['title'] . "'})\n";
            $query .= "Match(g:Genre {name : '$value'})\n";
            $query .= "Create(movie)-[:IN_GENRE]->(g)\n";
            app(Neo4j::class)->run($query);
        }


        // adding directors of movie
        foreach ($movieDirectors as $director){

            // if doesn't already exists in database
            if(!Persons::isExistByName($director['name']))
            {

                $query = "CREATE(person:Person:Director {";
                foreach ($director as $key => &$value){

                    $value = addslashes($value);

                    if($key == "born" || $key == "died")
                        $query .= $key . " : " . "date('" . $value . "')";
                    else
                        $query .= $key . " : " . "'" . $value . "'";

                    if($key !== array_key_last($director))
                        $query .= ",";
                }
                $query .= "})\n";

                app(Neo4j::class)->run($query);
            }

            $query = "MATCH(movie:Movie {title : '"  . $movie['title'] . "'})\n";
            $query .= "Match(person:Person {name : '" . $director['name'] . "'})\n";
            $query .= "CREATE (person)-[:DIRECTED]->(movie)\n";

            app(Neo4j::class)->run($query);
        }

        // adding actors
        foreach ($movieActors as $actor){

            // if doesn't already exists in database
            if(!Persons::isExistByName($actor['name']))
            {

                $query = "CREATE(person:Person:Actor{";
                foreach ($actor as $key => &$value){

                    $value = addslashes($value);

                    if($key == "born" || $key == "died")
                        $query .= $key . " : " . "date('" . $value . "')";
                    else
                        $query .= $key . " : " . "'" . $value . "'";

                    if($key !== array_key_last($actor))
                        $query .= ",";
                }
                $query .= "})\n";

                app(Neo4j::class)->run($query);
            }

            $query = "MATCH(movie:Movie {title : '"  . $movie['title'] . "'})\n";
            $query .= "Match(person:Person {name : '" . $actor['name'] . "'})\n";
            $query .= "CREATE (person)-[:ACTED_IN]->(movie)\n";

            app(Neo4j::class)->run($query);

        }



    }

    public static function test(){

//        $person = Persons::getPersonById(15407);
//
//        echo(strval($person->get('person')->getProperty('born')->convertToBolt()));

        $d = new DateTimeImmutable();
        $d = $d->setDate(1995, 07,16);

        $da = strtotime('1995-07-16');
        $boltTime = new Date($da);
        print_r($boltTime->toDateTime());

//        print_r(Date("Y-m-d",$d->getTimestamp()));




    }
}


/**
 * Movie :
 * Actor :
*/


/*
 * case1 : movie doesn't exist
 *      we create the movie node and link it to its genres ,
 *      then for each actor and director we check if it exists or not
 *          if it exists we create an edge ACTED_IN or directed
 *          else we create the node then the edges
 *
 * */
