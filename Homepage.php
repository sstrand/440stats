<?php include_once("teamcss.php"); ?>
<?php
    //Query the DB to get all the team stats for the users favorite team, or the randomly selected team
    $sql = "SELECT * FROM teamstats WHERE Id = '$teamId' AND Season = 2019";
    $results = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($results);

    $sqlLeaders = "SELECT * FROM teams WHERE Id = '$teamId'";
    $resultsLeaders = mysqli_query($conn, $sqlLeaders);
    $rowLeaders = mysqli_fetch_array($resultsLeaders);
    $teamABV = $rowLeaders['nameAbbr'];        
?>

<html>
    <head>
    <?php include_once("bootstrap.php"); ?>

        <style type = "text/css">
            .navbar-team-color-primary {
                background: rgba(<?php echo($primaryRGB1) ?>,<?php echo($primaryRGB2) ?>,<?php echo($primaryRGB3) ?>,1);
                color: white;
            }
            .navbar-team-color-secondary {
                background: rgba(<?php echo($secondaryRGB1) ?>, <?php echo($secondaryRGB2) ?>, <?php echo($secondaryRGB3) ?>, 1);
                color: white;
            }
            .card-league-color-primary{
                background: rgba(1,51,105,1);
                color: white;
            }
            .card-league-color-secondary{
                background: rgba(213,10,10,1);
                color: white;
            }
            a {
                color: white;
            }
            a:hover {
                color: rgba(<?php echo($secondaryRGB1) ?>, <?php echo($secondaryRGB2) ?>, <?php echo($secondaryRGB3) ?>, 1);
            }
            .row {
                text-align: center;
                padding-bottom: 40px;
            }
            .no-padding{
                padding-bottom: 0px;
            }
            .table-condensed{
                font-size: 14px;
                padding: 5px;
            }
            .add-space {
                padding-right: 10px;
                padding-left: 20px;
            }
            .logo {
                padding-top: 20px;
            }
        </style>

    </head>
    
    <body>
        <?php include_once("Header.php"); ?>

        <div class = "container">
        
            <div class = "row">
                <div class = "col-lg-1 logo"><img src="<?php echo 'img//logos//' .$teamName. '.png'?>" alt="Favorite team picture" height="100" width="150"></div><!--height="150" width="150"-->
                <div class = "col-lg-10 display-1"><?php echo $teamNameFull ?></div>
                <div class = "col-lg-1"></div>
            </div>
            <div class = "row display-4">Team Stats</div>
            <div class = "row">
                <div class = "col-lg-6">Record<br><?php echo ''.$row['Wins']. ' - ' .$row['Losses'].''; ?></div>
                <div class = "col-lg-6">Total Points<br><?php echo ''.$row['Points']. ''; ?></div>
            </div>
            <div class = "row display-4">Offensive Stats</div>
            <div class = "row">
                <div class = "col-lg-3">Passing Yards<br><?php echo ''.$row['Passing_Yards'].''; ?></div>
                <div class = "col-lg-3">Rushing Yards<br><?php echo ''.$row['Rushing_Yards'].''; ?></div>
                <div class = "col-lg-3">Passing Touchdowns<br><?php echo ''.$row['Passing_TD'].''; ?></div>
                <div class = "col-lg-3">Rushing Touchdowns<br><?php echo ''.$row['Rushing_TD'].''; ?></div>
            </div>

            <div class = "row display-4">Defensive Stats</div>
            <div class = "row">
                <div class = "col-lg-3">Passing Yards Allowed<br><?php echo ''.$row['Passing_Yards_Allowed'].''; ?></div>
                <div class = "col-lg-3">Rushing Yards Allowed<br><?php echo ''.$row['Rushing_Yards_Allowed'].''; ?></div>
                <div class = "col-lg-3">Passing Touchdowns Allowed<br><?php echo ''.$row['Passing_TD_Allowed'].''; ?></div>
                <div class = "col-lg-3">Rushing Touchdowns Allowed<br><?php echo ''.$row['Rushing_TD_Allowed'].''; ?></div>
            </div>
            
            <?
            /* This is to find the team leaders for various stat categories (e.g. who has the highest stat)
             * If queries the correct table for the position and finds which row has the max value for each individual stat.
             * The stat and player name are saved and used later to display.
            */

                $statLeader = mysqli_query($conn, "SELECT max(totalYards) FROM QB WHERE Team = '$teamABV' AND Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $passingYardsLeaderStats = $stat['max(totalYards)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM QB WHERE Team = '$teamABV' AND Season = 2019 AND TotalYards = '$passingYardsLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $passingYardsLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(touchdowns) FROM QB WHERE Team = '$teamABV' AND Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $passingTouchdownLeaderStats = $stat['max(touchdowns)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM QB WHERE Team = '$teamABV' AND Season = 2019 AND touchdowns = '$passingTouchdownLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $passingTouchdownLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(totalYards) FROM RB WHERE Team = '$teamABV' AND Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $rushingYardsLeaderStats = $stat['max(totalYards)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM RB WHERE Team = '$teamABV' AND Season = 2019 AND TotalYards = '$rushingYardsLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $rushingYardsLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(touchdowns) FROM RB WHERE Team = '$teamABV' AND Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $rushingTouchdownLeaderStats = $stat['max(touchdowns)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM RB WHERE Team = '$teamABV' AND Season = 2019 AND touchdowns = '$rushingTouchdownLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $rushingTouchdownLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(receptions) FROM WR WHERE Team = '$teamABV' AND Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(receptions) FROM TE WHERE Team = '$teamABV' AND Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receptionsLeaderStats = $stat1['max(receptions)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Team = '$teamABV' AND Season = 2019 AND receptions = '$receptionsLeaderStats'");
                }
                else{
                    $receptionsLeaderStats = $stat2['max(receptions)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Team = '$teamABV' AND Season = 2019 AND receptions = '$receptionsLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receptionsLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(yards) FROM WR WHERE Team = '$teamABV' AND Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(yards) FROM TE WHERE Team = '$teamABV' AND Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receivingYardsLeaderStats = $stat1['max(yards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Team = '$teamABV' AND Season = 2019 AND yards = '$receivingYardsLeaderStats'");
                }
                else{
                    $receivingYardsLeaderStats = $stat2['max(yards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Team = '$teamABV' AND Season = 2019 AND yards = '$receivingYardsLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receivingYardsLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(averageYards) FROM WR WHERE Team = '$teamABV' AND Season = 2019 AND receptions > 9");
                $statLeader2 = mysqli_query($conn, "SELECT max(averageyards) FROM TE WHERE Team = '$teamABV' AND Season = 2019 AND receptions > 9");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $yardsPerReceptionLeaderStats = $stat1['max(averageYards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Team = '$teamABV' AND Season = 2019 AND averageYards = '$yardsPerReceptionLeaderStats' AND receptions > 9");
                }
                else{
                    $yardsPerReceptionLeaderStats = $stat2['max(averageYards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Team = '$teamABV' AND Season = 2019 AND averageYards = '$yardsPerReceptionLeaderStats' AND receptions > 9");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $yardsPerReceptionLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(touchdowns) FROM WR WHERE Team = '$teamABV' AND Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(touchdowns) FROM TE WHERE Team = '$teamABV' AND Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receivingTouchdownLeaderStats = $stat1['max(touchdowns)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Team = '$teamABV' AND Season = 2019 AND touchdowns = '$receivingTouchdownLeaderStats'");
                }
                else{
                    $receivingTouchdownLeaderStats = $stat2['max(touchdowns)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Team = '$teamABV' AND Season = 2019 AND touchdowns = '$receivingTouchdownLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receivingTouchdownLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(combinedTackles) FROM LB WHERE Team = '$teamABV' AND Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(combinedTackles) FROM DB WHERE Team = '$teamABV' AND Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $tacklesLeaderStats = $stat1['max(combinedTackles)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM LB WHERE Team = '$teamABV' AND Season = 2019 AND combinedTackles = '$tacklesLeaderStats'");
                }
                else{
                    $tacklesLeaderStats = $stat2['max(combinedTackles)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM DB WHERE Team = '$teamABV' AND Season = 2019 AND combinedTackles = '$tacklesLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $tacklesLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(sacks) FROM LB WHERE Team = '$teamABV' AND Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(sacks) FROM DB WHERE Team = '$teamABV' AND Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $sacksLeaderStats = $stat1['max(sacks)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM LB WHERE Team = '$teamABV' AND Season = 2019 AND sacks = '$sacksLeaderStats'");
                }
                else{
                    $sacksLeaderStats = $stat2['max(sacks)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM DB WHERE Team = '$teamABV' AND Season = 2019 AND sacks = '$sacksLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $sacksLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];


            ?>
            <!-- Display all the team leaders for the team stats -->
            <div class = "row display-4">Team Leaders</div>
            <div class = "row">
                <div class = "col-lg-1"></div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Passing Yards</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $passingYardsLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $passingYardsLeaderStats?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Passing Touchdowns</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $passingTouchdownLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $passingTouchdownLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Rushing Yards</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $rushingYardsLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $rushingYardsLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Rushing Touchdowns</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $rushingTouchdownLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $rushingTouchdownLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Receptions</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $receptionsLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $receptionsLeaderStats ?> Receptions</div>
                    </div>
                </div>
            </div>

            <div class = "row">
            <div class = "col-lg-1"></div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Receiving Yards</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $receivingYardsLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $receivingYardsLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Receiving Yards Per Reception*</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $yardsPerReceptionLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $yardsPerReceptionLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Receiving Touchdowns</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $receivingTouchdownLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $receivingTouchdownLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Tackles</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $tacklesLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $tacklesLeaderStats ?> Tackles</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header navbar-team-color-primary">Sacks</div>
                        <div class="card-body navbar-team-color-secondary"><? echo $sacksLeaderFullName ?></div>
                        <div class="card-footer navbar-team-color-primary"><? echo $sacksLeaderStats ?> Sacks</div>
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class = "col-lg-3"></div>
                <div class = "col-lg-2">*Minimum 10 Receptions</div>
            </div>

            <?
            /* This is to find the league leaders for various stat categories (e.g. who has the highest stat in the whole leage)
             * If queries the correct table for the position and finds which row has the max value for each individual stat.
             * The stat and player name are saved and used later to display.
            */
                $statLeader = mysqli_query($conn, "SELECT max(totalYards) FROM QB WHERE Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $passingYardsLeagueLeaderStats = $stat['max(totalYards)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM QB WHERE Season = 2019 AND TotalYards = '$passingYardsLeagueLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $passingYardsLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(touchdowns) FROM QB WHERE Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $passingTouchdownLeagueLeaderStats = $stat['max(touchdowns)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM QB WHERE Season = 2019 AND touchdowns = '$passingTouchdownLeagueLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $passingTouchdownLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(totalYards) FROM RB WHERE Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $rushingYardsLeagueLeaderStats = $stat['max(totalYards)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM RB WHERE Season = 2019 AND TotalYards = '$rushingYardsLeagueLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $rushingYardsLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader = mysqli_query($conn, "SELECT max(touchdowns) FROM RB WHERE Season = 2019");
                $stat = mysqli_fetch_array($statLeader);
                $rushingTouchdownLeagueLeaderStats = $stat['max(touchdowns)'];
                $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM RB WHERE Season = 2019 AND touchdowns = '$rushingTouchdownLeagueLeaderStats'");
                $name = mysqli_fetch_array($statLeaderName);
                $rushingTouchdownLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(receptions) FROM WR WHERE Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(receptions) FROM TE WHERE Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receptionsLeagueLeaderStats = $stat1['max(receptions)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Season = 2019 AND receptions = '$receptionsLeagueLeaderStats'");
                }
                else{
                    $receptionsLeagueLeaderStats = $stat2['max(receptions)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE AND Season = 2019 AND receptions = '$receptionsLeagueLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receptionsLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(yards) FROM WR WHERE Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(yards) FROM TE WHERE Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receivingYardsLeagueLeaderStats = $stat1['max(yards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Season = 2019 AND yards = '$receivingYardsLeagueLeaderStats'");
                }
                else{
                    $receivingYardsLeagueLeaderStats = $stat2['max(yards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Season = 2019 AND yards = '$receivingYardsLeagueLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receivingYardsLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(averageYards) FROM WR WHERE Season = 2019 AND receptions > 9");
                $statLeader2 = mysqli_query($conn, "SELECT max(averageyards) FROM TE WHERE Season = 2019  AND receptions > 9");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $yardsPerReceptionLeagueLeaderStats = $stat1['max(averageYards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Season = 2019 AND averageYards = '$yardsPerReceptionLeagueLeaderStats' AND receptions > 9");
                }
                else{
                    $yardsPerReceptionLeagueLeaderStats = $stat2['max(averageYards)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Season = 2019 AND averageYards = '$yardsPerReceptionLeagueLeaderStats' AND receptions > 9");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $yardsPerReceptionLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(touchdowns) FROM WR WHERE Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(touchdowns) FROM TE WHERE Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $receivingTouchdownLeagueLeaderStats = $stat1['max(touchdowns)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM WR WHERE Season = 2019 AND touchdowns = '$receivingTouchdownLeagueLeaderStats'");
                }
                else{
                    $receivingTouchdownLeagueLeaderStats = $stat2['max(touchdowns)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM TE WHERE Season = 2019 AND touchdowns = '$receivingTouchdownLeagueLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $receivingTouchdownLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(combinedTackles) FROM LB WHERE Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(combinedTackles) FROM DB WHERE Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $tacklesLeagueLeaderStats = $stat1['max(combinedTackles)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM LB WHERE Season = 2019 AND combinedTackles = '$tacklesLeagueLeaderStats'");
                }
                else{
                    $tacklesLeagueLeaderStats = $stat2['max(combinedTackles)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM DB WHERE Season = 2019 AND combinedTackles = '$tacklesLeagueLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $tacklesLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];



                $statLeader1 = mysqli_query($conn, "SELECT max(sacks) FROM LB WHERE Season = 2019");
                $statLeader2 = mysqli_query($conn, "SELECT max(sacks) FROM DB WHERE Season = 2019");
                $stat1 = mysqli_fetch_array($statLeader1);
                $stat2 = mysqli_fetch_array($statLeader2);
                if($stat1 > $stat2){
                    $sacksLeagueLeaderStats = $stat1['max(sacks)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM LB WHERE Season = 2019 AND sacks = '$sacksLeagueLeaderStats'");
                }
                else{
                    $sacksLeagueLeaderStats = $stat2['max(sacks)'];
                    $statLeaderName = mysqli_query($conn, "SELECT FirstName, LastName FROM DB WHERE Season = 2019 AND sacks = '$sacksLeagueLeaderStats'");
                }
                $name = mysqli_fetch_array($statLeaderName);
                $sacksLeagueLeaderFullName = $name['FirstName'] . ' ' . $name['LastName'];

            ?>

            <!-- Display all the league leaders for the individual stats -->
            <div class = "row display-4">League Leaders</div>
            <div class = "row">
                <div class = "col-lg-1"></div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Passing Yards</div>
                        <div class="card-body card-league-color-secondary"><? echo $passingYardsLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $passingYardsLeagueLeaderStats?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Passing Touchdowns</div>
                        <div class="card-body card-league-color-secondary"><? echo $passingTouchdownLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $passingTouchdownLeagueLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Rushing Yards</div>
                        <div class="card-body card-league-color-secondary"><? echo $rushingYardsLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $rushingYardsLeagueLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Rushing Touchdowns</div>
                        <div class="card-body card-league-color-secondary"><? echo $rushingTouchdownLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $rushingTouchdownLeagueLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Receptions</div>
                        <div class="card-body card-league-color-secondary"><? echo $receptionsLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $receptionsLeagueLeaderStats ?> Receptions</div>
                    </div>
                </div>
            </div>

            <div class = "row">
            <div class = "col-lg-1"></div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Receiving Yards</div>
                        <div class="card-body card-league-color-secondary"><? echo $receivingYardsLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $receivingYardsLeagueLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Receiving Yards Per Reception*</div>
                        <div class="card-body card-league-color-secondary"><? echo $yardsPerReceptionLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $yardsPerReceptionLeagueLeaderStats ?> Yards</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Receiving Touchdowns</div>
                        <div class="card-body card-league-color-secondary"><? echo $receivingTouchdownLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $receivingTouchdownLeagueLeaderStats ?> Touchdowns</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Tackles</div>
                        <div class="card-body card-league-color-secondary"><? echo $tacklesLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $tacklesLeagueLeaderStats ?> Tackles</div>
                    </div>
                </div>
                <div class = "col-lg-2">
                    <div class="card">
                        <div class="card-header card-league-color-primary">Sacks</div>
                        <div class="card-body card-league-color-secondary"><? echo $sacksLeagueLeaderFullName ?></div>
                        <div class="card-footer card-league-color-primary"><? echo $sacksLeagueLeaderStats ?> Sacks</div>
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class = "col-lg-3"></div>
                <div class = "col-lg-2">*Minimum 10 Receptions</div>
            </div>
        </div>
    </body>
</html>