<?php include_once("teamcss.php"); ?>

<?php 
    include_once("config.php");
    //Get the year from the URL, used to only display stats for the selected year.
    $year = $_GET["year"];

    //Query the DB to get all the players, from all positions, for the selected year.
    $playerInfo = mysqli_query($conn, 
        "SELECT FirstName, LastName, Team, 'QB' as Position FROM QB WHERE Season=$year UNION 
        SELECT FirstName, LastName, Team, 'WR' as Position from WR WHERE Season=$year UNION 
        SELECT FirstName, LastName, Team, 'TE' as Position from TE WHERE Season=$year UNION
        SELECT FirstName, LastName, Team, 'RB' as Position from RB WHERE Season=$year UNION
        SELECT FirstName, LastName, Team, 'DB' as Position from DB WHERE Season=$year UNION
        SELECT FirstName, LastName, Team, 'LB' as Position from LB WHERE Season=$year UNION
        SELECT FirstName, LastName, Team, 'ST' as Position from ST WHERE Season=$year 
        ORDER BY LastName;");

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
            table#playerTable {
                border-collapse: collapse;   
            }
            #playerTable .playerRow:hover {
                background: #ADADAD; 
                color: white;
                cursor: pointer;
            }
            .yearList > div > a {
                color: black;
            }
        </style>
        <!-- Allows the table to be clickable, to load the player page with expanded stats -->
        <script>
        $(document).ready(function() {
            $('#playerTable tr').click(function() {
                var link = $(this).find("a").attr("href");
                if(link) {
                    window.location = link;
                }
            });
        });
        </script>
        <!-- Initializes the player table using DataTables. Turns on various options that are beneficial-->
        <script>
        $(document).ready(function() {
            $('#playerTable').DataTable( {
            "paging":   true,
            "pageLength": 20,
            "lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
            "info":     false,
            "order": [[ 2, "asc" ]]
            });
        } );
        </script>
        </head>

    <body>
        <?php include_once('Header.php'); ?>

        <div class = "row">
          <div class="container">
            <!-- Year selection. Reloads the page with the selected year to display players from that year. -->
            <div class="row justify-content-md-center yearList">
              <div class="col col-lg-1">
                <a href="PlayerDatabase.php?year=2019">2019</a>
              </div>
              <div class="col col-lg-1">
                <a href="PlayerDatabase.php?year=2018">2018</a>
              </div>
              <div class="col col-lg-1">
                <a href="PlayerDatabase.php?year=2017">2017</a>
              </div>
              <div class="col col-lg-1">
                <a href="PlayerDatabase.php?year=2016">2016</a>
              </div>
              <div class="col col-lg-1">
                <a href="PlayerDatabase.php?year=2015">2015</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Player table. Gets the player info from the respective SQL query and adds a row for each player.-->
        <div class="container">
          <table class="table table-hover table-striped table-sm sortable" id = "playerTable">
            <thead>
              <tr class="">
                <th scope="col">Position</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Team</th>
              </tr>
            </thead>
          
            <tbody>
            <?php 
              while($row = mysqli_fetch_array($playerInfo)) {
                echo '
                <tr class="playerRow">
                  <td><a href="Player.php?pos='.$row["Position"].'&first='.$row["FirstName"].'&last='.$row["LastName"].'&year='.$year.'"></a>'.$row['Position']. '</td>
                  <td>'.$row['FirstName']. '</td>
                  <td>'.$row['LastName']. '</td>
                  <td>'.$row['Team']. '</td>
                </tr>';
              }
            ?>
            </tbody>
            </table>
          </div>
    </body>
</html>