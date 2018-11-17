<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.13.18
    
    Filename: RegisterIntern.php
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Internship Registration </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>College Internship</h1>
    <h2>Internship Registration</h2>
    <?php
    $errors = 0;
    $email = "";
    if (empty($_POST['email'])) {
    // Failure, empty email field
        ++$errors;
        echo "<p>You need to enter an email address</p>\n";
    } else {
    // Success
        $email = stripslashes($_POST['email']);
        // If email is invalid
        if (preg_match("/^[\w-]+(\.[\w-])*@[\w-]+(\.[\w-]+)*(\.[A-Za-z]{2,})$/i", $email) == 0) {
            ++$errors;
            echo "<p>You need to enter a valid email address</p>\n";
            $email = "";
        }
    }
    
    if (empty($_POST['password'])) {
    // Failure, empty password field
        ++$errors;
        echo "<p>You need to enter a password</p>\n";
    } else {
        $password = stripslashes($_POST['password']);
    }
    
    if (empty($_POST['password2'])) {
    // Failure, empty confirmation password field
        ++$errors;
        echo "<p>You need to enter a confirmation password</p>\n";
    } else {
        $password2 = stripslashes($_POST['password2']);
    }
    if (!empty($password) && !empty($password2)) {
        if (strlen($password) < 6) {
        // Failure, too short passsword
            ++$errors;
            echo "<p>The password is too short</p>\n";
            $password = "";
            $password2 = "";
        }
        
        if ($password <> $password2) {
        // Failure, passwords do not match
            ++$errors;
            echo "<p>The passwords do not match.</p>\n";
            $password = "";
            $password2 = "";
        }
    }
    
    // Database Variables
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "quiet-Texas-16";
    // Variable that holds the "database engine object", if success
    // Variable that holds false, if failure
    $DBConnect = false;
    $DBName = "internships2";
    
    // Do NOT execute database code if we have errors
    if ($errors == 0) {
        $DBConnect = mysqli_connect($hostname, $username, $passwd);
        if (!$DBConnect) {
        // Failure, connection to database fails
            ++$errors;
            echo "<p>Unable to connect to the database server" . 
                 ", Error Code: " . mysqli_connect_error() . "</p>";
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
    
    $TableName = "interns";
    if ($errors == 0) {
        $SQLString = "SELECT count(*) FROM $TableName" . 
                     " WHERE email='$email'";
        $queryResult = mysqli_query($DBConnect, $SQLString);
        if ($queryResult) {
        // Success, query did not fail, HOWEVER, you could possibly have no data
            $row = mysqli_fetch_row($queryResult);
            if ($row[0] > 0) {
            // If we found a match in the database, do not upload new registration
             ++$errors;
             echo "<p>The e-mail address entered (" . 
                  htmlentities($email) . ") is already registered.</p>"; 
            }
        }
    }
    if ($errors == 0) {
        $first = stripslashes($_POST['first']);
        $last = stripslashes($_POST['last']);
        $SQLString = "INSERT INTO $TableName" . 
                     " (first, last, email, password_md5)" . 
                     " VALUES('$first', '$last', '$email', '" . md5($password) .
                     "')";
        // Send in query string
        $queryResult = mysqli_query($DBConnect, $SQLString);
        if (!$queryResult) {
        // Failure, query failure     
             ++$errors;
             echo "<p>Unable to save your registration information" . 
                  ", Error Code: " . mysqli_error($DBConnect) . "</p>";           
        } else {
            $internID = mysqli_insert_id($DBConnect);
        }
    }
    
    if ($errors == 0) {
        $internName = $first . " " . $last;
        echo "<p>Thank you, $internName. Your new Intern ID is" .
             " <strong>$internID</strong>.</p>\n";
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
    
    // If we have any errors from ^
    if ($errors > 0) {
        echo "<p>Please use your browser's BACK button to return to the form and" . 
             " fix the errors indicated.</p>\n";
    }
    ?>

</body>

</html>
