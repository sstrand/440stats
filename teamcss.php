<?php
    session_start();
    include_once("config.php");
    
    //$teamName = "None";
    //$teamNameFull = "Team Name";

    //If not logged in, set a session variable with a random team
    if(!isset($_SESSION['team_id'])) {
        $_SESSION['team_id'] = rand(0,31);
        $teamId = $_SESSION['team_id'];
    } else {
        $teamId = $_SESSION['team_id'];
    }

    //Query the teamstats database to get the team name from the team id
    $result = mysqli_query($conn, "SELECT * FROM teamstats WHERE Id = '" . $teamId . "' and Season='2019'");
    
    if ($rows = mysqli_fetch_array($result)) {
        
        $teamName = $rows['Name'];
        $teamNameFull = $rows['Full_Name'];
    } else {
        $teamName = "None";
    }
    
    //Set the session variable with the team id
    $teamId = $_SESSION['team_id'];

    //Get the RGB values for the team's primary and secondary color. Used in the CSS for various items.
    $colorSQL = "SELECT * FROM teams WHERE Id = '$teamId'";
    $colorSQLResults = mysqli_query($conn, $colorSQL);
    $colorSQLRow = mysqli_fetch_array($colorSQLResults);
    $primaryRGB1 = $colorSQLRow['primaryRGB1'];
    $primaryRGB2 = $colorSQLRow['primaryRGB2'];
    $primaryRGB3 = $colorSQLRow['primaryRGB3'];
    $secondaryRGB1 = $colorSQLRow['secondaryRGB1'];
    $secondaryRGB2 = $colorSQLRow['secondaryRGB2'];
    $secondaryRGB3 = $colorSQLRow['secondaryRGB3'];
    
?>