
<?php
 header('Location: report.php');
 
 $servername = "127.0.0.1";
 $username = "root";
$password = "Chormun168";
 $dbname = "test";



//sql = "INSERT INTO source (source_name, source_url, source_begin, source_end)
//VALUES('$source_name', '$source_url', '$source_begin', '$source_end');" ;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else
    echo "Connected successfully\n";


//$source_name = $source_url = $source_begin = $source_end = "";
//print_r($_POST);
$source_name = $_POST['source_name'];
$source_url = $_POST['source_url'];
$source_begin = $_POST['source_begin'];
$source_end = $_POST['source_end'];

//https://www.youtube.com/watch?v=2HVKizgcfjo
$stmt=$conn->prepare("INSERT INTO source (source_name, source_url, source_begin, source_end)
values(?,?,?,?)");
$stmt->bind_param("ssss", $source_name, $source_url, $source_begin, $source_end);
$stmt->execute();
echo "record goto source_table successfully\n $source_url";

$last_id = $conn->insert_id;
echo $last_id;
$stmt->close();

//https://www.gutenberg.org/cache/epub/132/pg132.txt


//obtain the text from the url....will change to $source_url later
$website = file_get_contents("$source_url");//'https://www.gutenberg.org/cache/epub/132/pg132.txt');

//take the begin and end
//$website = stristr($website, "$source_begin");
//$website = stristr($website, "$source_end",true);


if ($source_begin != null) {
    $website = preg_replace("/[^a-zA-Z 0-9]+/", " ", $website);
    $website = stristr($website, "$source_begin");
}
if ($source_end != null) {
    $website = preg_replace("/[^a-zA-Z 0-9]+/", " ", $website);
    $website = stristr($website, "$source_end",true);
}


//remove punctuation marks: https://stackoverflow.com/questions/4762546/what-is-the-best-way-to-remove-punctuation-marks-symbols-diacritics-special-c
$words = preg_replace("/[^a-zA-Z 0-9]+/", " ", $website);

//make it to uppercase
$words = strtoupper( $words);
// str_word_count,get an array of all the words on the entire page
//array_count_values, count of each one,
// returning an array of the results in a key value pair of the word and the count

//print_r
$wordArray = (array_count_values(str_word_count($words, 1)) );

//$sql = "DELETE FROM occurrence WHERE occurrence_id>0";
//
//if ($conn->query($sql) === TRUE) {
//    echo "Record deleted successfully";
//} else {
//    echo "Error deleting record: " . $conn->error;
//}

foreach ($wordArray as $word => $freq) {

    echo "freq of $word is $freq\n";
    $sql = "INSERT INTO occurrence (source_id, word, freq)VALUES ( '$last_id', '$word', '$freq')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
}



$conn->close();
