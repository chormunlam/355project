<! -- ->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail report</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php
include('navbar.html');
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */

    $servername = "127.0.0.1";
    $username = "root";
    $password = "Chormun168";
    $dbname = "test";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $id = $_GET['id'];

    $sum=0;
    $sqll = "SELECT  SUM(freq) from occurrence where source_id='$id'";
    $resultt = $conn->query($sqll);
    //display data on web page
    while($row = mysqli_fetch_array($resultt)){
        echo " Total word: ". $row['SUM(freq)'];
        echo "<br>";
        $sum= $row['SUM(freq)'];
    }
    //echo "llllll".$sum;




    // Attempt select query execution
    $sql = "SELECT word, freq FROM  occurrence where source_id='$id' order by freq desc ";



    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>
                    <tr>
                    <th>word</th>
                    <th>frequency</th>
                    <th>percentage</th>
                    
                    </tr>";


            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                //echo "<td>" . $row['source_id'] . "</td>";
                //echo "<td>" . $row['source_name'] . "</td>";
                //echo "<td>" . '<a href="'.$row['source_url'].'">'.$row['source_name'].'</a>'. "</td>";
                echo "<td>" . $row['word'] . "</td>";
                echo "<td>" . $row['freq'] . "</td>";
                $percentage= $row['freq'] /$sum;
                $percentage=$percentage*100;
                $percentage = sprintf('%0.2f', round($percentage, 2));
                echo "<td>" . $percentage. '%'."</td>";

                echo "</tr>";
            }

            // Free result set
            mysqli_free_result($result);
        } else {
            echo "No records matching your query were found.";
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);

    ?>


</body>

</html>

