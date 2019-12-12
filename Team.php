<?php include_once("teamcss.php"); ?>

<?php 
	include_once("config.php");

    //Return to the homepage is any of these variables are not set
    //This shouldn't happen, but just in case
	if(!isset($_GET["id"]) || !isset($_GET["year"])) {
		header("Location: Homepage.php");
	}

    //Get the team ID and year from the URL
    $Id = $_GET["id"];
    $year = $_GET["year"];
    $statsArray = array();

    //Queries the teamstats DB with the selected team ID and year to get all the team stats.
    $sql = "SELECT * FROM teamstats WHERE Id = '$Id' AND Season = $year";
    $results = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($results);

?>

<html>
    <head>
        <?php include('bootstrap.php'); ?>

        <style type = "text/css">
            .navbar-team-color-primary {
                    background: rgba(<?php echo($primaryRGB1) ?>,<?php echo($primaryRGB2) ?>,<?php echo($primaryRGB3) ?>,1);
            }
            .navbar-team-color-secondary {
                background: rgba(<?php echo($secondaryRGB1) ?>, <?php echo($secondaryRGB2) ?>, <?php echo($secondaryRGB3) ?>, 1);
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
        </style>
    </head>

    <body>
        <?php include_once('Header.php'); ?>
        
        <div class = "container">
            <!-- Displays all the queried team stats for the selected team-->
            <div class = "row">
                <div class = "col-lg-1 logo"><img src="<?php echo 'img//logos//' .$row["Name"]. '.png'?>" alt="Favorite team picture" height="100" width="150"></div>
                <div class = "col-lg display-3"><?php echo '' .$row["Full_Name"]. '' ?></div>
            </div>

            <?php
            echo'
                <div class = "row">
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Record</div>
                            <div class="card-body">'.$row["Wins"].' - '.$row["Losses"].' - '.$row["Ties"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Total yards</div>
                            <div class="card-body">'.$row["Total_Yards"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Passing yards</div>
                            <div class="card-body">'.$row["Passing_Yards"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Rushing Yards</div>
                            <div class="card-body">'.$row["Rushing_Yards"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Passing Touchdowns</div>
                            <div class="card-body">'.$row["Passing_TD"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Rushing Touchdowns</div>
                            <div class="card-body">'.$row["Rushing_TD"].'</div>
                        </div>
                    </div>
                </div>

                <div class = "row">
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Defensive Yards Allowed</div>
                            <div class="card-body">'.$row["Yards_Allowed"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Defensive Passing Yards Allowed</div>
                            <div class="card-body">'.$row["Passing_Yards_Allowed"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Defensive Rushing Yards Allowed</div>
                            <div class="card-body">'.$row["Rushing_Yards_Allowed"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">First Downs Allowed</div>
                            <div class="card-body">'.$row["First_Downs_Allowed"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Interceptions</div>
                            <div class="card-body">'.$row["Interceptions"].'</div>
                        </div>
                    </div>
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Passing Touchdowns Allowed</div>
                            <div class="card-body">'.$row["Passing_TD_Allowed"].'</div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-lg-2">
                        <div class="card">
                            <div class="card-header">Rushing Touchdowns Allowed</div>
                            <div class="card-body">'.$row["Rushing_TD_Allowed"].'</div>
                        </div>
                    </div>
                </div>
            ';
            ?>
        </div>
    </body>
</html>