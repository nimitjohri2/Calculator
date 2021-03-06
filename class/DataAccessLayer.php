<?php

//include_once ('../config/config.php');
include_once ('./config/config.php');

//All the communication with the database flows through the DataAccessLayer
class DataAccessLayer
{
    //function to insert equation in the database
    function Log($equation)
    {
    	//Load attributes from config file
        global $connstring;
        global $host;
        global $username;
        global $password;
        global $database;

        //$connect = mysqli_connect($host, $username, $password, $database);

        try {
            //$conn = pg_connect($connstring);

		//Connect database
            $connect = mysqli_connect($host, $username, $password, $database);

		//Prepared statement to prevent SQL Injection
            $query = $connect->prepare('INSERT INTO log (equation) VALUES (?)');
            $query->bind_param('s', $equation);
            $query->execute();

            //for postgreSQL
            //$result = pg_prepare($conn, 'INSERT', 'INSERT INTO LOG (EQUATION) VALUES ($1)');
            //$result = pg_execute($conn, 'INSERT', array($equation));

            //if(pg_affected_rows($result) > 0)
            if($query->affected_rows > 0)
                return true;
            else
                return false;
        }
        catch (Exception $e)
        {
            return false;
        }
        //Return binary indicators for success or failure
    }

    //function to maintain only recent 10 records in the database
    function Maintainence()
    {
        //global $connstring;
        global $host;
        global $username;
        global $password;
        global $database;

        //$conn = pg_connect($connstring);

        $connect = mysqli_connect($host, $username, $password, $database);

	//Delete all but most recent 10 rows
        $query = $connect->prepare('delete from log 
                                    where id not in (
                                        select l1.id 
                                        from log l1 inner join (select * from log order by id desc limit 10) l2
                                        on l1.id = l2.id)');
        $query->execute();

        //fpr PostgreSQL
        //$query = 'DELETE FROM LOG WHERE ID NOT IN (SELECT ID FROM LOG ORDER BY ID DESC LIMIT 10)';
        //$result = pg_send_query($conn, $query);
        //$result = pg_get_result($conn);
    }

	//Function to return the live feed for the most recent 10 rows from the database
    function Update()
    {
        //global $connstring;
        global $host;
        global $username;
        global $password;
        global $database;

        //$conn = pg_connect($connstring);

        $connect = mysqli_connect($host, $username, $password, $database);

        //$connect = mysqli_connect($servername, $username, $password, $database);

        $query = 'SELECT id, equation FROM log ORDER BY id DESC LIMIT 10';
        $result = $connect->query($query);

	//Format feed as array of objects to preserve order while transmitting JSON
        $feed = [];
        while ($equation = $result->fetch_assoc())
        {
            //$feed[$equation['id']] = $equation['equation'];
            
            //Array of objects
            array_push($feed, array($equation['id'], $equation['equation']));
        }


        //For postgresSQL
        /*
        $query = 'SELECT ID, EQUATION FROM LOG ORDER BY ID DESC LIMIT 10';
        $result = pg_send_query($conn, $query);
        $result = pg_get_result($conn);

        $feed = array();

        while ($equation = pg_fetch_assoc($result))
        {
            $feed[$equation['id']] = $equation['equation'];
        }
        */

        return $feed;
    }
}
