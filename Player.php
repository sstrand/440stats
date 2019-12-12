<?php include_once("teamcss.php"); ?>
<?php 
	include_once("config.php");

    //Return to the homepage if any of these variables are not set (Name, position and season)
    //This shouldn't happen, but just in case
	if(!isset($_GET["first"]) || !isset($_GET["last"]) || !isset($_GET["pos"]) || !isset($_GET["year"])) {
		header("Location: Homepage.php");
	}

    $firstName = $_GET["first"];
    $lastName = $_GET["last"];
    $position = strtoupper($_GET["pos"]);
    $year = $_GET["year"];

    /* SQL statement to get every row from the correct table with the name of the selected
     * player. Also contains an inner join with the teams table, to turn a team name abbreviation
     * into the full team name (used to get the correct team picture.)
    */
    $sqlPlayer = 
       "SELECT $position.*, teams.name 
        FROM $position 
        INNER JOIN teams on $position.Team = teams.nameAbbr 
        WHERE FirstName = '$firstName' AND LastName = '$lastName' AND Season = $year
    ";
    $resultsPlayer = mysqli_query($conn, $sqlPlayer);
    $rowPlayer = mysqli_fetch_array($resultsPlayer);

    //Retrieve all the SQL column names from the correct table for the selected player, and store 
    //them in the array $categories.
    $sqlCol = "SELECT column_name FROM information_schema.columns WHERE table_name='$position' ";
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
            .card-custom {
                max-width: 200px;
                min-width: 200px;
            }
        </style>
    </head>

    <body>
        <?php include_once('Header.php'); ?>
        
        <div class = "container">
        
            <div class = "row">
                <img src="<?php echo 'img//logos//' .$rowPlayer["name"]. '.png'?>" alt="Favorite team picture" height="100" width="150">
                <div class = "col-lg display-3"><?php echo '' .$firstName. ' ' .$lastName.'' ?></div>
            </div>

            <?php
                /* This is to display the stats for the selected player. It is split between Quarterbacks
                 * and Tight Ends/Wide Recievers, since the stat categories are different.
                */
                $counter = 4;
                //Loop through the total number of columns. Starts with a counter offset to ignore
                //columns not to be displayed (name, season, etc.)
                echo '<div class="row mt-5 justify-content-center">';
                while($counter < count($categories)) {
                    echo'
                        <div class="card card-custom mx-2 mb-3">
                            <div class="card-body">
                                <h5 class="card-title">'.$categories[$counter].'</h5>
                                <p class="card-text ">'.$rowPlayer[$counter].'</p>
                            </div>
                        </div>
                    ';
                    $counter++;
                }
                echo '</div></br>';
            ?>
        </div>
    </body>
</html>