<?  
    session_start(); 
    include_once("config.php");

    $query1 = mysqli_query($conn, "SELECT * FROM qb WHERE LastName = 'Rodgers';");
    $query2 = mysqli_query($conn, "SELECT * FROM qb WHERE LastName = 'Brady';");

    $player1 = mysql_fetch_array($query1);
    $player2 = mysql_fetch_array($query2);
?>

<script>

const CHART = document.getElementById("LineChart");
const CHART2 = document.getElementById("LineChart2");

                                // Customize: https://www.chartjs.org/docs/latest/charts/line.html

let LineChart = new Chart (CHART, {
    type: 'line',
    data: data = {
        labels: ["2015", "2016", "2017", "2018", "2019",],
        datasets: [
            {
                label: 'My First Dataset',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,192,192,0.4)", //only occurs when fill = true
                borderColor: "rgba(75,192,192,1)",
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
                data: [<? $player1['TotalYards'] ?>, 1333, 1250, 1445, 752], //to increase the amount of data, increase the amount of labels
            },
            {
                label: 'My Second Dataset',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,75,192,0.4)",
                borderColor: "rgba(75,72,192,1)",
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
                data: [800, 1200, 1532, 854, 1003],
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
})

let LineChart2 = new Chart (CHART2, {
    type: 'line',
    data: data = {
        labels: ["2015", "2016", "2017", "2018", "2019"],
        datasets: [
            {
                label: 'My First Dataset',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,192,192,0.4)", //only occurs when fill = true
                borderColor: "rgba(75,192,192,1)",
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
                data: [3800, 3300, 4200, 5200, 3300], //to increase the amount of data, increase the amount of labels
            },
            {
                label: 'My Second Dataset',
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,75,192,0.4)",
                borderColor: "rgba(75,72,192,1)",
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
                data: [4500, 3800, 4100, 5000, 2800],
            }
        ]
    },
    options: {
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