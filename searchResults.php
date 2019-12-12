<?php 
    session_start(); 
    include_once("teamcss.php");
    include_once("config.php");
    $search = $_GET["searched"];

    //Queries the position tables to find any row that either the first name or last name is similar to the user search.
    $results = mysqli_query($conn, "SELECT FirstName, LastName, Team, Season, 'QB' as Position FROM QB WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'RB' as Position FROM RB WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'WR' as Position FROM WR WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'TE' as Position FROM TE WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'DB' as Position FROM DB WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'LB' as Position FROM LB WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'
                          UNION SELECT FirstName, LastName, Team, Season, 'ST' as Position FROM ST WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'");
?>

<html>
    <head>
        <?php include('bootstrap.php'); ?>
      
        <style>
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
            .add-space {
                padding-right: 10px;
                padding-left: 20px;       
            }
            .text {
                margin-bottom: 20px;
                padding: 15px;
            }
            table#searchTable {
                border-collapse: collapse;   
            }
            #searchTable tr:hover {
                background: #ADADAD; 
                color: white;
                cursor: pointer;
            }
            .yearList > div > a {
                color: black;
                font-size: 18px;
            }
            .toppadding {
                padding-top: 20px;
            }
        </style>

        <!-- Allows the table to be clickable, to load the player page with expanded stats -->
        <script>
        $(document).ready(function() {
            $('#searchTable tr').click(function() {
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
            $('#searchTable').DataTable( {
            "paging":   false,
            "info":     false,
            "searching": false
            });
        });
        </script>
    </head>

    <body>
        <?php include_once('Header.php'); ?>

        <!--Displays the player table for the user sleected search term. Allows each row (each player) to be clickable
            to view expanded stats.-->
        <div class="container">
          <table class="table table-hover table-striped table-sm sortable" id = "searchTable">
            <thead>
              <tr class="">
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Team</th>
                <th scope="col">Position</th>
                <th scope="col">Year</th>
              </tr>
            </thead>
          
            <tbody>
            <?php 
              while($row = mysqli_fetch_array($results)) {
                echo '
                <tr>
                  <td><a href="Player.php?pos='.$row["Position"].'&first='.$row["FirstName"].'&last='.$row["LastName"].'&year=2019"></a>'.$row['FirstName']. '</td>
                  <td>'.$row['LastName']. '</td>
                  <td>'.$row['Team']. '</td>
                  <td>'.$row['Position'].'</td>
                  <td>'.$row['Season'].'</td>
                </tr>';
              }
            ?>
            </tbody>
            </table>
          </div>
    </body>
</html>