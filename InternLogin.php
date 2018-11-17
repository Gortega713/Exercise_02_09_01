<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    Author: Gabriel Ortega
    Date: 11.13.18
    
    Filename: InternLogin
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> College Interships </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>College Internships</h1>
    <h2>Register / Login</h2>
    <p>New interns, please complete the top form to register as a user. <br> 
       Returning users, please complete the second form to login.</p>
       
    <h3>New Intern Registration</h3>
    <!--  HTML Web Form, take to RegisterIntern.php  -->
    <form action="RegisterIntern.php" method="post">
    <!--   Name Field    -->
        <p>Enter your name: 
            First
            <input type="text" name="first">
            Last 
            <input type="text" name="last">
        </p>
        
    <!--   Email    -->
    <p>Enter your email address:
       <input type="text" name="email">      
    </p>
    
    <!--   Password    -->
    <p>Enter a password for your account:
       <input type="password" name="password">      
    </p>
    
    <!--   Confirm Password    -->
    <p>Confirm your password:
       <input type="password" name="password2">      
    </p>
    <p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
    <input type="reset" name="reset" value="Reset Registration Form"> &nbsp;
    <input type="submit" name="register" value="Register">
    </form>
    
    <h3>Returning Intern Login</h3>
    <!--  HTML Web Form, take to RegisterIntern.php  -->
    <form action="VerifyLogin.php" method="post">
    <!--   Email    -->
    <p>Enter your email address:
       <input type="text" name="email">      
    </p>
    
    <!--   Password    -->
    <p>Enter your password for your account:
       <input type="password" name="password">      
    </p>

    <p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
    <input type="reset" name="reset" value="Reset Login Form"> &nbsp;
    <input type="submit" name="register" value="Log In">
    </form>

</body>

</html>
