<?php

namespace App\DAOs;

use \Laudis\Neo4j\Bolt\Session as Neo4j;

class Persons

{

    public static function getPersonsPage($page,$genre,$search,$age,$livingstatus,$director,$nationality)
    {
        $nbr_movies= ($page-1)*28;
        $query="match (person:Person)";
        if ($director != "" && $director !="all") {
            if ($director == "director") {
                $query .= "-[:DIRECTED]->(movie:Movie)";
            } elseif($director == "actor")
                $query .= "-[:ACTED_IN]->(movie:Movie)";
        }
        else
            $query .="-[:ACTED_IN|:DIRECTED]->(movie:Movie)";

        if ($genre !="" && $genre!="all")
            $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
        else
            $query .= " where ";

        if ($search != "" && $search != "all") {
            $query .= "(toLower(person.name) contains toLower('$search') or toLower(movie.title) contains toLower('$search')) and ";
        }

        if ($age != "" && $age != "all") {
            if ($age != ">60") {
                $date1 = date_format(date_create("-" . substr($age, 3, 2) . " years"), 'Y-m-d');
                $date2 = date_format(date_create("-" . substr($age, 0, 2) . " years"), 'Y-m-d');
                $query .= "date('$date1') <= date(person.born) <= date('$date2') and ";
            }
            else
            {
                $date3 = date_format(date_create("-" . substr($age, 1, 2) . " years"), 'Y-m-d');
                $query .= "date(person.born) < date('$date3') and ";
            }
        }
        if ($livingstatus !="" && $livingstatus!="all")
        {
            if($livingstatus=="died")
                $query .= "person.died is not null and ";
            else
                $query .= "person.died is null and ";
        }
        if ($nationality!="" && $nationality !="all")
        {
            //$Nationalities=array("American","Canadian","English","French","German","Japanese","Indian","Chinese","Other");

            switch ($nationality){
                case "American":
                    $query .= "(person.bornIn contains 'USA' or person.bornIn contains 'United States') and ";
                    break;
                case "English":
                    $query .= "(person.bornIn contains 'UK' or person.bornIn contains 'England') and ";
                    break;
                case "Canadian":
                    $query .= "(person.bornIn contains 'CA' or person.bornIn contains 'Canada') and ";
                    break;
                case "French":
                    $query .= "(person.bornIn contains 'France') and ";
                    break;
                case "German":
                    $query .= "(person.bornIn contains 'Germany') and ";
                    break;
                case "Japanese":
                    $query .= "(person.bornIn contains 'Japan') and ";
                    break;
                case "Chinese":
                    $query .= "(person.bornIn contains 'China') and ";
                    break;
                case "Indian":
                    $query .= "(person.bornIn contains 'India') and ";
                    break;
                case "Other":
                    $query .="not(person.bornIn contains 'USA' or person.bornIn contains 'United States' or person.bornIn contains 'CA' or person.bornIn contains 'Canada' or person.bornIn contains 'UK' or person.bornIn contains 'England' or person.bornIn contains 'France' or person.bornIn contains 'Germany' or person.bornIn contains 'Japan' or person.bornIn contains 'China' or person.bornIn contains 'India') and ";
                    break;

            }
        }

        $query .= "person.poster is not null return distinct person skip $nbr_movies limit 28";
        //dd($query);
        return app(Neo4j::class)->run($query);
    }




    public static function getPersonsCount($genre,$search,$age,$livingstatus,$director,$nationality)
    {
        $query="match (person:Person)";

        if ($director != "" && $director !="all") {
            if ($director == "director") {
                $query .= "-[:DIRECTED]->(movie:Movie)";
            } else
                $query .= "-[:ACTED_IN]->(movie:Movie)";
        }
        else
            $query .="-[:ACTED_IN|:DIRECTED]->(movie:Movie)";

        if ($genre !="" && $genre!="all")
            $query .= "-[:IN_GENRE]->(genre:Genre) where genre.name='$genre' and ";
        else
            $query .= " where ";

        //search
        if ($search != "" && $search != "all") {
            $query .= "(toLower(person.name) contains toLower('$search') or toLower(movie.title) contains toLower('$search')) and ";
        }
        //director
        if ($age != "" && $age != "all") {
            if ($age != ">60") {
                $date1 = date_format(date_create("-" . substr($age, 3, 2) . " years"), 'Y-m-d');
                $date2 = date_format(date_create("-" . substr($age, 0, 2) . " years"), 'Y-m-d');
                $query .= "date('$date1') <= date(person.born) <= date('$date2') and ";
            }
            else
            {
                $date3 = date_format(date_create("-" . substr($age, 1, 2) . " years"), 'Y-m-d');
                $query .= "date(person.born) < date('$date3') and ";
            }
        }

        //livingstatus
        if ($livingstatus !="" && $livingstatus!="all")
        {
            if($livingstatus=="died")
                $query .= "person.died is not null and ";
            else
                $query .= "person.died is null and ";
        }

        //Nationality
        if ($nationality!="" && $nationality !="all")
        {

            switch ($nationality){
                case "American":
                    $query .= "(person.bornIn contains 'USA' or person.bornIn contains 'United States') and ";
                    break;
                case "English":
                    $query .= "(person.bornIn contains 'UK' or person.bornIn contains 'England') and ";
                    break;
                case "Canadian":
                    $query .= "(person.bornIn contains 'CA' or person.bornIn contains 'Canada') and ";
                    break;
                case "French":
                    $query .= "(person.bornIn contains 'France') and ";
                    break;
                case "German":
                    $query .= "(person.bornIn contains 'Germany') and ";
                    break;
                case "Japanese":
                    $query .= "(person.bornIn contains 'Japan') and ";
                    break;
                case "Chinese":
                    $query .= "(person.bornIn contains 'China') and ";
                    break;
                case "Indian":
                    $query .= "(person.bornIn contains 'India') and ";
                    break;
                case "Other":
                    $query .="not(person.bornIn contains 'USA' or person.bornIn contains 'United States' or person.bornIn contains 'CA' or person.bornIn contains 'Canada' or person.bornIn contains 'UK' or person.bornIn contains 'England' or person.bornIn contains 'France' or person.bornIn contains 'Germany' or person.bornIn contains 'Japan' or person.bornIn contains 'China' or person.bornIn contains 'India') and ";
                    break;

            }
        }

        $query .= "person.poster is not null return count( distinct person)as nbr";
        //dd($query);
        return app(Neo4j::class)->run($query)[0]->get('nbr');
    }

}

