<?php include_once("teamcss.php"); ?>

<?php 
    include_once("config.php");

    if(!isset($_GET["pos"])) {
        $position = "QB";
    } else {
        $position = $_GET["pos"];
    }

    $playerInfo = mysqli_query($conn, "SELECT DISTINCT FirstName, LastName, Team, '$position' as Position, Season FROM $position ORDER BY LastName;");

    //Query the databases to get the stats for both selected players. Also get the column names from the
    //table to use a reference for each stats.
    if (isset($_POST['playerSubmit'])) {
        //Split the values from the select box value fields. Store them in appropriate variables.
        $arr = explode("_",$_POST['player1']);
        $season1 = $arr[0];
        $firstName1 = $arr[1];
        $lastName1 = $arr[2];
        $position1 =  strtoupper($arr[3]);

        $arr = explode("_",$_POST['player2']);
        $season2 = $arr[0];
        $firstName2 = $arr[1];
        $lastName2 = $arr[2];
        $position2 =  strtoupper($arr[3]);
        
        //If the positions do not match, send an error and do not query the database to get the stats.
        if($position1 != $position2) {
            $errorMessage = "Please select two players that play the same position";
            $displayStats = false;
        } else {
            //Separate SQL queries to get the entire row for the two players
            $displayStats = true;

            $player1SQL = mysqli_query($conn, 
                "SELECT $position1.*, teams.* 
                 FROM $position1 
                 INNER JOIN teams on $position1.Team = teams.nameAbbr 
                 WHERE FirstName='$firstName1' AND LastName='$lastName1' AND Season=$season1
                ");
            $row1 = mysqli_fetch_array($player1SQL);

            $player2SQL = mysqli_query($conn, 
                "SELECT $position2.*, teams.* 
                 FROM $position2 
                 INNER JOIN teams on $position2.Team = teams.nameAbbr 
                 WHERE FirstName='$firstName2' AND LastName='$lastName2' AND Season=$season2
                ");
            $row2 = mysqli_fetch_array($player2SQL);

            //Retrieve all the SQL column names from the correct table for the selected player, and store 
            //them in the array $categories.
            $sqlCol = "SELECT column_name FROM information_schema.columns WHERE table_name='$position1'";
            $resultsCol = mysqli_query($conn, $sqlCol);
            $categories = array();

            foreach ($resultsCol as $res) {
                foreach($res as $column => $value){
                    //Our column names are camel case. This splits the string into array elements based on 
                    //upper case letters and rejoins it into one string and saves it into an array.
                    $arr = preg_split('/(?=[A-Z])/', $value);
                    $temp = implode(' ', $arr);
                    array_push($categories, $temp);

                }
            }
        }
    }
?>

<html>
    <head>
        <?php include('bootstrap.php'); ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>

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
                background: rgba(<?php echo($row1["primaryRGB1"]) ?>,<?php echo($row1["primaryRGB2"]) ?>,<?php echo($row1["primaryRGB3"]) ?>,1);
            }
            .results-team-color-secondary {
                background: rgba(<?php echo($row2["primaryRGB1"]) ?>, <?php echo($row2["primaryRGB2"]) ?>, <?php echo($row2["primaryRGB3"]) ?>, 1);
            }
            .results-divider {
                background: white;
            }
            .formSpace {
                margin-top: 10 !important;
            }
            .yearList > div > a {
                color: black;
            }
            .activePos {
                color: green;
            }
        </style>
        <!-- JS code to initialize our two drop down boxes using Select2  -->
        <script>
            $(document).ready(function(){
                $('#player1').selectize({ 
                    
                });
                $('#player2').selectize({
                
                });

            });
        </script>
    </head>

    <body>
        <?php include_once('Header.php'); ?>
        <span></span>
        <div class="container">

        <div class = "row">
          <div class="container">
            <div class="row justify-content-md-center yearList">
              <div class="col col-lg-1 ">
                <?php if($position == "QB") echo '<a href="PlayerComparison.php?pos=QB" class="text-success">QB</a>';
                      else echo '<a href="PlayerComparison.php?pos=QB" class="text-black-50">QB</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "RB") echo '<a href="PlayerComparison.php?pos=RB" class="text-success">RB</a>';
                      else echo '<a href="PlayerComparison.php?pos=RB" class="text-black-50">RB</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "WR") echo '<a href="PlayerComparison.php?pos=WR" class="text-success">WR</a>';
                      else echo '<a href="PlayerComparison.php?pos=WR" class="text-black-50">WR</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "TE") echo '<a href="PlayerComparison.php?pos=TE" class="text-success">TE</a>';
                      else echo '<a href="PlayerComparison.php?pos=TE" class="text-black-50">TE</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "ST") echo '<a href="PlayerComparison.php?pos=ST" class="text-success">ST</a>';
                      else echo '<a href="PlayerComparison.php?pos=ST" class="text-black-50">ST</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "LB") echo '<a href="PlayerComparison.php?pos=LB" class="text-success">LB</a>';
                      else echo '<a href="PlayerComparison.php?pos=LB" class="text-black-50">LB</a>'; ?>
              </div>
              <div class="col col-lg-1">
              <?php if($position == "DB") echo '<a href="PlayerComparison.php?pos=DB" class="text-success">DB</a>';
                      else echo '<a href="PlayerComparison.php?pos=DB" class="text-black-50">DB</a>'; ?>
              </div>
            </div>
          </div>
        </div>


            <form method="post" name="playerCompare">

                <div class="form-row">
                    <div class="col">
                        <select name='player1' id="player1">
                            <option disabled selected value>Select a player</option>
                            <?php 
                                while($row = mysqli_fetch_array($playerInfo)) {
                                    echo '
                                    <option value="'.$row["Season"].'_'.$row["FirstName"].'_'.$row["LastName"].'_'.$row["Position"].'">'.$row["Position"].' '.$row["FirstName"].' '.$row["LastName"].' ('.$row["Season"].')</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col">
                        <select name='player2' id="player2">
                            <option disabled selected value>Select a player</option>
                            <?php 
                                mysqli_data_seek($playerInfo, 0); //Move the pointer back to the first element of the results array
                                while($row = mysqli_fetch_array($playerInfo)) {
                                    echo '
                                    <option value="'.$row["Season"].'_'.$row["FirstName"].'_'.$row["LastName"].'_'.$row["Position"].'">'.$row["Position"].' '.$row["FirstName"].' '.$row["LastName"].' ('.$row["Season"].')</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="playerSubmit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <span class="text-danger"><?php if (isset($errorMessage)) { echo $errorMessage; } ?></span> <!-- Displays an error is the two selected players do not play the same position -->
        </div>


        <div class="container">
            <!-- Only display the graphs/data is the team and year form has been submitted -->
            <?php
                //Only display the comparrison if the submit button was pressed and there are no errors
                if (isset($_POST['playerSubmit']) && $displayStats) {
            ?>

            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h1><?php echo $row1["FirstName"]; ?> </h1>
                    <h1><?php echo $row1["LastName"]; ?> </h1>
                    <h4><?php echo $row1["Season"]; ?> </h4>
                </div>
                <div class="col-md-auto">
                    <h1><?php echo $row2["FirstName"]; ?> </h1>
                    <h1><?php echo $row2["LastName"]; ?> </h1>
                    <h4><?php echo $row2["Season"]; ?> </h4>
                </div>
            </div>


            <?php
                /* This is the resultsfor comparing two players. Since the players are of the same position, the stats
                 * can be compared directly. For each stat, a progress bar is used with the percentage of the total
                 * combinded stat that player has.
                */


                //Create a denominator by adding both values, then divide the values by the denominator.
                //Use php's round function to get a whole number
                for($counter = 5; $counter < count($categories); $counter++) {
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
                
            ?>
        </div>

        <div style="margin: 0 auto; width:800px; height:400px;">
        <div class = "row display-4">Comparison Chart</div>
            <canvas id="LineChart"></canvas>
        </div>

    <script>
       var CHART = document.getElementById("LineChart");

                                // Customize: https://www.chartjs.org/docs/latest/charts/line.html

                                

    let LineChart = new Chart (CHART, {
    type: 'line',
    data: data = {
        labels: [

        <? for($counter = 5; $counter < count($categories); $counter++) {
            ?> " <?echo($categories[$counter]) ?> ", <?
        }

        ?>
        ],
        datasets: [
            {
                label: '<?php echo $firstName1 . ' ' . $lastName1 ?>',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(<?php echo($row1["primaryRGB1"]) ?>,<?php echo($row1["primaryRGB2"]) ?>,<?php echo($row1["primaryRGB3"]) ?>,.4)", //only occurs when fill = true
                borderColor: "rgba(<?php echo($row1["primaryRGB1"]) ?>,<?php echo($row1["primaryRGB2"]) ?>,<?php echo($row1["primaryRGB3"]) ?>,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rbga(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220.220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: [

                <? for($counter = 5; $counter < count($categories); $counter++) {
                        echo($row1[$counter]) ?>, <?

                }

                ?>
                
                ],
            },
            {
                label: '<?php echo $firstName2 . ' ' . $lastName2 ?>',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(<?php echo($row2["primaryRGB1"]) ?>,<?php echo($row2["primaryRGB2"]) ?>,<?php echo($row2["primaryRGB3"]) ?>,0.4)",
                borderColor: "rgba(<?php echo($row2["primaryRGB1"]) ?>,<?php echo($row2["primaryRGB2"]) ?>,<?php echo($row2["primaryRGB3"]) ?>,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rbga(75,72,192,1)",
                pointBackgroundColor: '#fff',
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,72,192,1)",
                pointHoverBorderColor: "rgba(220,220.220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: [

                    <? for($counter = 5; $counter < count($categories); $counter++) {
                        echo($row2[$counter]) ?>, <?
                    }

                    ?>
                    ],
                }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
})
    </script>

<? } ?>

    </body>
</html>