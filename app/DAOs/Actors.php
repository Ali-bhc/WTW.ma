<?php

namespace App\DAOs;

use Faker\Provider\cs_CZ\DateTime;
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
    /*
    public static function getActorsPage($page,$genre,$search,$age,$livingstatus,$director,$nationality)
    {
        $nbr_movies= ($page-1)*28;
        $query="match (actor:Actor)";
        if ($director=="director")
        {
            $query.="-[:DIRECTED]->(movie:Movie)";
        }
        else
            $query.="-[:ACTED_IN]->(movie:Movie)";

        if ($genre !="" && $genre!="all")
            $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
        else
            $query .= " where ";

        if ($search != "" && $search != "all") {
            $query .= "(toLower(actor.name) contains toLower('$search') or toLower(movie.title) contains toLower('$search')) and ";
        }

        if ($age != "" && $age != "all") {
            if ($age != ">60") {
            $date1 = date_format(date_create("-" . substr($age, 3, 2) . " years"), 'Y-m-d');
            $date2 = date_format(date_create("-" . substr($age, 0, 2) . " years"), 'Y-m-d');
            $query .= "date('$date1') <= date(actor.born) <= date('$date2') and ";
            }
           else
            {
                $date3 = date_format(date_create("-" . substr($age, 1, 2) . " years"), 'Y-m-d');
                $query .= "date(actor.born) > date('$date3') and ";
            }
        }
        if ($livingstatus !="" && $livingstatus!="all")
        {
            if($livingstatus=="died")
                $query .= "actor.died is not null and ";
            else
                $query .= "actor.died is null and ";
        }
        if ($nationality!="" && $nationality !="all")
        {
            //$Nationalities=array("American","Canadian","English","French","German","Japanese","Indian","Chinese","Other");

            switch ($nationality){
                case "American":
                    $query .= "actor.bornIn contains 'USA' or actor.bornIn contains 'United States' and ";
                    break;
                case "English":
                    $query .= "actor.bornIn contains 'UK' or actor.bornIn contains 'England' and ";
                    break;
                case "Canadian":
                    $query .= "actor.bornIn contains 'CA' or actor.bornIn contains 'Canada' and ";
                    break;
                case "French":
                    $query .= "actor.bornIn contains 'France' and ";
                    break;
                case "German":
                    $query .= "actor.bornIn contains 'Germany' and ";
                    break;
                case "Japanese":
                    $query .= "actor.bornIn contains 'Japan' and ";
                    break;
                case "Chinese":
                    $query .= "actor.bornIn contains 'China' and ";
                    break;
                case "Indian":
                    $query .= "actor.bornIn contains 'India' and ";
                    break;
                case "Other":
                    $query .="not(actor.bornIn contains 'USA' or actor.bornIn contains 'United States' or actor.bornIn contains 'CA' or actor.bornIn contains 'Canada' or actor.bornIn contains 'UK' or actor.bornIn contains 'England' or actor.bornIn contains 'France' or actor.bornIn contains 'Germany' or actor.bornIn contains 'Japan' or actor.bornIn contains 'China' or actor.bornIn contains 'India') and ";
                    break;

            }
        }

        $query .= "actor.poster is not null return distinct actor skip $nbr_movies limit 28";
        //dd($query);
        return app(Neo4j::class)->run($query);
    }

    public static function getActorsCount($genre,$search,$age,$livingstatus,$director,$nationality)
    {
        $query="match (actor:Actor)";

        if ($director=="director")
        {
            $query.="-[:DIRECTED]->(movie:Movie)";
        }
        else
            $query.="-[:ACTED_IN]->(movie:Movie)";

        if ($genre !="" && $genre!="all")
            $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
        else
            $query .= " where ";

        //search
        if ($search != "" && $search != "all") {
            $query .= "(toLower(actor.name) contains toLower('$search') or toLower(movie.title) contains toLower('$search')) and ";
        }
        //director
        if ($age != "" && $age != "all") {
            if ($age != ">60") {
                $date1 = date_format(date_create("-" . substr($age, 3, 2) . " years"), 'Y-m-d');
                $date2 = date_format(date_create("-" . substr($age, 0, 2) . " years"), 'Y-m-d');
                $query .= "date('$date1') <= date(actor.born) <= date('$date2') and ";
            }
            else
            {
                $date3 = date_format(date_create("-" . substr($age, 1, 2) . " years"), 'Y-m-d');
                $query .= "date(actor.born) > date('$date3') and ";
            }
        }

        //livingstatus
        if ($livingstatus !="" && $livingstatus!="all")
        {
            if($livingstatus=="died")
                $query .= "actor.died is not null and ";
            else
                $query .= "actor.died is null and ";
        }

        //Nationality
        if ($nationality!="" && $nationality !="all")
        {

            switch ($nationality){
                case "American":
                    $query .= "actor.bornIn contains 'USA' or actor.bornIn contains 'United States' and ";
                    break;
                case "English":
                    $query .= "actor.bornIn contains 'UK' or actor.bornIn contains 'England' and ";
                    break;
                case "Canadian":
                    $query .= "actor.bornIn contains 'CA' or actor.bornIn contains 'Canada' and ";
                    break;
                case "French":
                    $query .= "actor.bornIn contains 'France' and ";
                    break;
                case "German":
                    $query .= "actor.bornIn contains 'Germany' and ";
                    break;
                case "Japanese":
                    $query .= "actor.bornIn contains 'Japan' and ";
                    break;
                case "Chinese":
                    $query .= "actor.bornIn contains 'China' and ";
                    break;
                case "Indian":
                    $query .= "actor.bornIn contains 'India' and ";
                    break;
                case "Other":
                    $query .="not(actor.bornIn contains 'USA' or actor.bornIn contains 'United States' or actor.bornIn contains 'CA' or actor.bornIn contains 'Canada' or actor.bornIn contains 'UK' or actor.bornIn contains 'England' or actor.bornIn contains 'France' or actor.bornIn contains 'Germany' or actor.bornIn contains 'Japan' or actor.bornIn contains 'China' or actor.bornIn contains 'India') and ";
                    break;

            }
        }

        $query .= "actor.poster is not null return count( distinct actor)as nbr";
        //dd($query);
        return app(Neo4j::class)->run($query)[0]->get('nbr');
    }
    */
}
