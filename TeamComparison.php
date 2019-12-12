<?php include_once("teamcss.php"); ?>

<?php 

    include_once("config.php");
    //Query the DB to get all team info for display. This does not include team stats, only general info.
    $teamInfo = mysqli_query($conn, "SELECT * FROM teams WHERE Id >= 0;");

    if (isset($_POST['teamSubmit'])) {
        $team1Id = $_POST['team1'];
        $team2Id = $_POST['team2'];
        $year1 = $_POST['year1'];
        $year2 = $_POST['year2'];

        //Two separate queries for each team. This will get all the stats for both teams.
        $sql1 = "SELECT * FROM teamstats WHERE Id = '$team1Id' AND Season = $year1";
        $results1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($results1);

        $sql2 = "SELECT * FROM teamstats WHERE Id = '$team2Id' AND Season = $year2";
        $results2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($results2);

        //Get a list of all the column names (each stat) for the teams.
        $sqlCol = "SELECT column_name FROM information_schema.columns WHERE table_name='teamstats'";
        $resultsCol = mysqli_query($conn, $sqlCol);
        $categories = array();

        foreach ($resultsCol as $res) {
            foreach($res as $column => $value){
                $temp = str_replace("_", " ", $value);
                array_push($categories, $temp);

            }
        }

        $teamColorSql1 = "SELECT * FROM teams WHERE Id = '$team1Id'";
        $teamColorResults1 = mysqli_query($conn, $teamColorSql1);
        $teamColorRow1 = mysqli_fetch_array($teamColorResults1);

        $teamColorSql2 = "SELECT * FROM teams WHERE Id = '$team2Id'";
        $teamColorResults2 = mysqli_query($conn, $teamColorSql2);
        $teamColorRow2 = mysqli_fetch_array($teamColorResults2);

    }
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
            .team-compare-greater {
                color: green;
                font-weight: bold;
            }
            .team-bars {
                height: 30px; 
                margin-bottom: 50px;
                font-size: 20px;
            }
            .results-team-color-primary {
                background: rgba(<?php echo($teamColorRow1["primaryRGB1"]) ?>,<?php echo($teamColorRow1["primaryRGB2"]) ?>,<?php echo($teamColorRow1["primaryRGB3"]) ?>,1);
            }
            .results-team-color-secondary {
                background: rgba(<?php echo($teamColorRow2["primaryRGB1"]) ?>, <?php echo($teamColorRow2["primaryRGB2"]) ?>, <?php echo($teamColorRow2["primaryRGB3"]) ?>, 1);
            }
            .results-divider {
                background: white;
            }

        </style>
    </head>

    <body>

        <?php include_once('Header.php'); ?>

        <div class="container">
            </br>
            <!-- Team and year select form -->
            <form role="form" action="" method="post" name="teamcompare" class="was-validated">
                <div class="form-row">
                    <div class="col-5 form-group">
                        <select name="team1" class="form-control custom-select" required>
                            <option value="">Select Team</option>

                            <?php 
                                while($row = mysqli_fetch_array($teamInfo)) {
                                    echo '<option value="'.$row["id"].'">'.$row["fullName"].'</option>';
                                }
                            ?>

                        </select>
                        <div class="invalid-feedback">Please select a team</div>
                    </div>
                    <div class="col-5 form-group">
                        <select name="team2" class="form-control custom-select" required>
                            <option value="">Select Team</option>
                            <?php 
                                mysqli_data_seek($teamInfo, 0);
                                while($row = mysqli_fetch_array($teamInfo)) {
                                    echo '<option value="'.$row["id"].'">'.$row["fullName"].'</option>';
                                }
                            ?>
                        </select>
                        <div class="invalid-feedback">Please select a team</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-5 form-group">
                        <select name="year1" class="form-control custom-select" required>
                            <option value="">Select Year</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>

                        </select>
                        <div class="invalid-feedback">Please select a year</div>
                    </div>
                    <div class="col-5 form-group">
                        <select name="year2" class="form-control custom-select" required>
                            <option value="">Select Year</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                        </select>
                        <div class="invalid-feedback">Please select a year</div>
                    </div>
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary " id="teamSubmit" name="teamSubmit">Submit</button>
                    </div>
                </div>
            </form>


        <!-- Only display the graphs/data is the team and year form has been submitted -->
        <?php
            if (isset($_POST['teamSubmit'])) {
        ?>


        <div class="row justify-content-between">
            <div class="col-4">
                <img src="<?php echo 'img//logos//' .$row1["Name"]. '.png'?>" alt="Team One logo" height="100" width="150"></img></br>
                <h1><?php echo $row1["Name"]; ?> </h1>
                <h4><?php echo $row1["Season"]; ?> </h4>
            </div>
            <div class="col-4">
                <img src="<?php echo 'img//logos//' .$row2["Name"]. '.png'?>" alt="Team two logo" height="100" width="150"></img></br>
                <h1><?php echo $row2["Name"]; ?> </h1>
                <h4><?php echo $row2["Season"]; ?> </h4>
            </div>
        </div>


        <?php
            //Create a denominator by adding both values, then divide the values by the denominator.
            //Use php's round function to get a whole number
            for($counter = 5; $counter < 25; $counter++) {
                $denom = intval($row1[$counter]) + intval($row2[$counter]);

                //If $denom is zero, that means both values are zero. If that is the case,
                //set both sides of the progress bar to 50%
                if(!$denom == 0) {
                    $num1 = round((intval($row1[$counter]) / $denom) * 100, 0);
                    $num2 = round((intval($row2[$counter]) / $denom) * 100, 0);
                } else {
                    $num1 = 50;
                    $num2 = 50;
                }
        ?>
        
                <div class="d-flex justify-content-center"><h3 style=> <?php echo $categories[$counter]; ?> </h3></div>
                <div class="progress team-bars" style="">
                    <div class="progress-bar results-team-color-primary" role="progressbar" style="width:<?php echo $num1; ?>%">
                        <?php echo $row1[$counter]; ?>
                    </div>
                    <div class="progress-bar results-divider" role="progressbar" style="width:.1%"></div>

                    <div class="progress-bar results-team-color-secondary" role="progressbar" style="width:<?php echo $num2; ?>%">
                        <?php echo $row2[$counter]; ?>
                    </div>
                </div>
        
        <?php
                }
            }
        ?>
        </div>
    </body>
</html>
