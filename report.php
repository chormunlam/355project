<! -- //https://www.tutorialrepublic.com/php-tutorial/php-mysql-select-query.php source_url, source_begin, source_end, parsed_dtm-->
<!https://www.youtube.com/watch?v=39Kd1UCQu8M>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" type="text/css" href="css/style">
</head>
<body>
<h1>Report of Parse</h1>

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
    if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Attempt select query execution
    $sql = "SELECT * FROM source order by source_id desc limit 10";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
                    <tr>
                    <th>source_id</th>
                    <th>source_name</th>
                    <th>source_url</th>
                    <th>source_begin</th>
                    <th>source_end</th>
                    <th>parsed_dtm</th>
                    <th>word<th>
                    </tr>";


            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['source_id'] . "</td>";
                echo "<td>" . $row['source_name'] . "</td>";
                echo "<td>" . '<a href="'.$row['source_url'].'">'.$row['source_name'].'</a>'. "</td>";
                echo "<td>" . $row['source_begin'] . "</td>";
                echo "<td>" . $row['source_end'] . "</td>";
                echo "<td>" . $row['parsed_dtm'] . "</td>";
                echo '<td><a href="detail.php?id='.$row['source_id'].'" class="buttonize">View</a></td>';

                echo "</tr>";
            }

            // Free result set
            mysqli_free_result($result);
        } else{
            echo "No records matching your query were found.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);

    ?>


</body>

</html>

