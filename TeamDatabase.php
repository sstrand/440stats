<?php include_once("teamcss.php"); ?>

<?php 

    include_once("config.php");
    $year = $_GET["year"];

    //Queries the DB to get a list of all teams. Does not include stats, only general info.
    $teamInfo = mysqli_query($conn, "SELECT * FROM teamstats WHERE Id >= 0 and Season=$year;");

    //Retrieve all the SQL column names, and store them in the array $categories.
    $sqlCol = "SELECT column_name FROM information_schema.columns WHERE table_name='teamstats'";
    $resultsCol = mysqli_query($conn, $sqlCol);
    $categories = array();

    foreach ($resultsCol as $res) {
        foreach($res as $column => $value){

            $temp = str_replace("_", " ", $value);
            array_push($categories, $temp);

        }
    }
?>

<html>
    <head>
        <?php include('bootstrap.php'); ?>

        <style>
            table {
                margin: auto;
                width: 75% !important; 
            }
            h1 {
                align: center;
            }
            th {
                cursor: pointer;
            }
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
            .add-space {
                padding-right: 10px;
                padding-left: 20px;       
            }
            .text {
                margin-bottom: 20px;
                padding: 15px;
            }
            table#teamTable {
                border-collapse: collapse;   
            }
            #teamTable td:hover {
                cursor: pointer;
            }
            #teamTable .teamRow:hover {
                background: #ADADAD; 
                color: white;
            }
            .yearList > div > a {
                color: black;
            }
        </style>
        <!-- Allows the table to be clickable, to load the team page with expanded stats -->
        <script>
        $(document).ready(function() {
            $('#teamTable tr').click(function() {
                var href = $(this).find("a").attr("href");
                if(href) {
                    window.location = href;
                }
            });
        });
        </script>

        <!-- Initializes the team table using DataTables. Turns on various options that are beneficial-->
        <script>
        $(document).ready(function() {
            $('#teamTable').DataTable( {
            "info":     false,
            "paging":   false,
            "searching": false
            });
        } );
        </script>
    </head>

    <body>
        <?php include_once('Header.php'); ?>

        <div class = "row">
            <!-- Year selection. Reloads the page with the selected year to display players from that year. -->
            <div class="container">
            <div class="row justify-content-md-center yearList">
                <div class="col col-lg-1">
                <a href="TeamDatabase.php?year=2019">2019</a>
                </div>
                <div class="col col-lg-1">
                <a href="TeamDatabase.php?year=2018">2018</a>
                </div>
                <div class="col col-lg-1">
                <a href="TeamDatabase.php?year=2017">2017</a>
                </div>
                <div class="col col-lg-1">
                <a href="TeamDatabase.php?year=2016">2016</a>
                </div>
                <div class="col col-lg-1">
                <a href="TeamDatabase.php?year=2015">2015</a>
                </div>
            </div>
            </div>

        </div>

        <div class="container-fluid">
            <table class="table table-hover table-striped table-sm" algin = "center" id = "teamTable">
                <thead>
                    <tr>
                      <th scope="col"><?php echo $categories[2]; ?></th>
                        <?php
                        //Print out all the column names into the table header
                        for($counter = 4; $counter < 15; $counter++) {
                            echo '<th scope="col">'.$categories[$counter].'</th>';
                        }
                        ?>
                    </tr>
                </thead>
                
                <tbody>
                  <?php 
                    //Print out all the data for the SQL query into rows. Makes each row clickable to go to
                    //another page with expanded stats.
                    while($row = mysqli_fetch_array($teamInfo)) {

                    echo '<tr class="teamRow">';
                    echo '<td><a href="Team.php?id='.$row["Id"].'&year='.$year.'"></a>'.$row[2].'</td>';
                    for($counter = 4; $counter < 15; $counter++) {
                        echo '<td>'.$row[$counter].'</th>';
                    }
                    echo '</tr>';
                    }

                  ?>
                </tbody>
            </table>
        </div>
        
    </body>
</html>