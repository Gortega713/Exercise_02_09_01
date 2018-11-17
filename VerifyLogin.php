<!DOCTYPE html>
<html lang="en">

<head>
    <!--  
    Author: Gabriel Ortega
    Date: 11.15.18
    
    Filename: VerifyLogin.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Verify Intern Login </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>College Internship</h1>
    <h2>Verify Intern Login</h2>
    <?php
    $errors = 0;
    
    // Database Variables
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "quiet-Texas-16";
    $DBConnect = false;
    $DBName = "internships2";
    $tableName = "interns";
    
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
    
    if ($errors == 0) {
    // Retrieve state from database to pass on to rest of website
        $SQLString = "SELECT internID, first, last FROM $tableName" .
                     " WHERE email='" . stripslashes($_POST['email']) . 
                     "' AND password_md5='" . md5(stripslashes($_POST['password'])) .
                     "'";
        $queryResult = mysqli_query($DBConnect, $SQLString);
        if (!$queryResult) {
        // Failure, syntax error in sql String
            ++$errors;
            echo "<p>Query not executed, bad SQL syntax.</p>\n";
        }
        if ($errors == 0) {
            if (mysqli_num_rows($queryResult) == 0) {
            // "Failure" User is not in database, no data; NOT AN ERROR/Good data, however, consider an error
                ++$errors;
                echo "<p>The e-mail address/password combination entered is not valid.</p>\n";
            } else {
            // "Success" User is in database
                // Explode data into an associative array
                $row = mysqli_fetch_assoc($queryResult);
                $internID = $row['internID'];
                $internName = $row['first'] . " " . $row['last'];
                // "Let Go" of data
                mysqli_free_result($queryResult);
                echo "<p>Welcome back, $internName!</p>\n";
            }
        }
    }
    
    // If there IS a connection, close it
    if ($DBConnect) {
        echo "<p>Closing database connection</p>\n";
        mysqli_close($DBConnect);
    }
    
    if ($errors == 0) {
        echo "<form action='AvailableOpportunities.php' method='post'>";
        echo "<input type='hidden' name='internID' value='$internID'>\n";
        echo "<input type='submit' name='submit' value='View Available Opportunities'>\n";
        echo "</form>";
    }
    
    // If we have ANY errors ^
    if ($errors > 0) {
        echo "<p>Please use your browser's BACK button to return to the form and" . 
             " fix the errors indicated.</p>\n";
    }
    ?>

</body>

</html>
