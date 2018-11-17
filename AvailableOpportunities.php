<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.15.18
    
    Filename: AvailableOpportunities
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Available Opportunities </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>College Internship</h1>
    <h2>Available Opportunities</h2>
    
    <?php
    // REQUEST has whatever is in GET or POST, used just for scalability
    if (isset($_REQUEST['internID'])) {
        $internID = $_REQUEST['internID'];
    } else {
        $internID = -1;
    }
    
    $errors = 0;
    
    // Database Variables
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "quiet-Texas-16";
    $DBConnect = false;
    $DBName = "internships2";
    
    if ($errors == 0) {
        $DBConnect = mysqli_connect($hostname, $username, $passwd);
        if (!$DBConnect) {
        // Failure, connection to database fails
            ++$errors;
            echo "<p>Unable to connect to the database server" . 
                 ", Error Code: " . mysqli_connect_error() . "</p>\n";
        } else {
        // Success, connection to database was successful
            $result = mysqli_select_db($DBConnect, $DBName);
            if (!$result) {
            // Failure, database selection fails    
                 ++$errors;
                 echo "<p>Unable to select the database \"$DBName\"" . 
                      ", Error Code: " . mysqli_error($DBConnect) . "</p>";
            }
        }
    }
    
    $tableName = "interns";
    if ($errors == 0) {
        $SQLString = "SELECT * FROM $tableName" . 
                     " WHERE internID='$internID'";
        $queryResult = mysqli_query($DBConnect, $SQLString);
        if (!$queryResult) {
        // Failure, query fails, syntax error
            ++$errors;
            echo "<p>Unable to execute the query,<br> error code: " . mysqli_errno($DBConnect) . 
                                                    ": " . mysqli_error($DBConnect) . "</p>\n";
        }
    }
    
    // If there IS a connection, close it
    if ($DBConnect) {
        echo "<p>Closing database connection</p>\n";
        mysqli_close($DBConnect);
    }
    ?>

</body>

</html>
