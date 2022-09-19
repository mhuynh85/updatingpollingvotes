<?php
//Functions used in polling with a mySQL database
//gather and update votes for a chosen item
//As written, requires: a table with name TABLE_NAME
//a column of choices called COLUMN_OF_VOTABLE_ITEMS
//and an int column called VOTES


//create constants for connecting to a database
//credentials for a local database
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('HOST', 'ENTER HOST HERE');
    define('USER', 'ENTER USERNAME HERE');
    define('PASS', 'ENTER PASSWORD HERE');
    define('DB', 'ENTER DATABASE HERE');
} else {
    //connection for a remote database
    define('HOST', 'ENTER HOST NAME HERE');
    define('USER', 'ENTER USERNAME HERE');
    define('PASS', 'ENTER PASSWORD HERE');
    define('DB', 'ENTER DATABASE HERE');
}

//using constants above, connet to a mySQL database
function connectToDB()
{
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    return $conn;
}

//gathers number of votes from a chosen item
function gatherVotes($itemReceivingVotes)
{
    $con = connectToDB();

    //returns number of votes matching an item that received votes from
    //a column of votable items
    $sqlQuery = "SELECT VOTES FROM TABLE_NAME WHERE COLUMN_OF_VOTABLE_ITEMS = '$itemReceivingVotes';";

     //run query
    $results = mysqli_query($con, $sqlQuery);

    //creates an associative array of votes for a single item
    $record = mysqli_fetch_array($results, MYSQLI_ASSOC);

    //gather votes from associative array
    $numberOfVotes = $record['VOTES'];

    //close connection
    mysqli_close($con);

    return $numberOfVotes;
}

//update database by adding 1 to a column of votes for a given item
function updateVotes($existingVotes, $itemReceivingVotes)
{
    //connect
    $con = connectToDB();

    //add a vote to existing votes
    $updateVotes = $existingVotes += 1;

    //updates table with new number of votes for column matching 
    //user votes
    $sqlQuery = "UPDATE TABLE_NAME SET VOTES ='$updateVotes' WHERE COLUMN_OF_VOTABLE_ITEMS = '$itemReceivingVotes';";

    //run query
    mysqli_query($con, $sqlQuery);

    //close connection
    mysqli_close($con);
}
