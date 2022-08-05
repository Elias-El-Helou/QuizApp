<?php
session_start();
$text="";
$color = "";
$loginColor="white";
$type = ""; 
$_SESSION["username"]="";
$_SESSION["password"]="";
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["logIn"])) {
    
    $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
        die(mysqli_connect_errno() . " : " . mysqli_connect_error());
    $userType = $_POST["choose"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($userType == "Admin") {
        $type = "admin";
    } else if ($userType == "Random-User") {
        $type = "user";
    }
    $query = "Select count(*) from " . $type . " where username = '$username' and password = '$password';";
    $numResult = mysqli_query($link, $query);
    $line = mysqli_fetch_row($numResult);

    $res = $line[0];
    if ($res == 0)  {
        $color = "red";
        $loginColor="red";
        $text="Error in Username or Password!";
        }
    else {
        if ($userType == "Admin") {

        header("Location:adminPage.php");
        $query = "Select idadmin  from admin where username = '$username' and password = '$password' ";
        $result = mysqli_query($link, $query);
        $line = mysqli_fetch_row($result);
        $idAdmin = $line[0];
        $_SESSION["id"] = $idAdmin;
        $_SESSION["userType"] = $userType;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        
        }
        else{
        header("Location:userPage.php");
        $query = "Select userid  from user where username = '$username' and password = '$password' ";
        $result = mysqli_query($link, $query);
        $line = mysqli_fetch_row($result);
        $userId = $line[0];
        $_SESSION["id"] = $userId;
        $_SESSION["userType"] = $userType;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
       
           
        }
    }
}

?>
<html>

<head>
    <title>
        Login page
    </title>
    <style>
        span{
            color:red;
            font-weight:bold;
            font-size:13px;
            font-family:'Courier New', Courier, monospace;
        }
        body {
            background-color: rgb(19, 0, 94);
            text-align: center;
            padding-top: 5px;
        }

        .div {
            padding-top: 30px;
            margin: auto;
            margin-top :50px;
            background-color:black;
            border-radius: 12px;
            text-align: center;
            width: 60%;
            height: 80%;
            background-image: url("images/loginphoto.png");

        }

        form {
            padding-top: 40px;
            margin-top: 15%;
            margin-left: 23%;
            background-color: lightgrey;
            width: 500px;
            border-radius: 16px;
            height: 260px;
        }

        label {
            font-size: 27px;
            font-family: 'Courier New', Courier, monospace;
        }

        .title {
            background-color: lightgray;
            font-family: monospace;
            border-radius: 13px;
        }

        #login {
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            font-weight: bold;
            color: <?php echo $loginColor ?>;
        }

        #login:hover {
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }

        select {
            border-radius:6px;
            background-color: rgb(19, 0, 94);
            color: white;
            border: 1px solid;
            font-size: 25px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }

        .write {
            border-radius:6px;
            height: 36px;
            font-size: large;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            border-color: <?php echo $color ?>
        }
    </style>
</head>

<body>
    <div class="div">
        <div class="title">
            <h1 style="text-decoration:underline">Welcome To Your Progamming Language Tester!</h1>
            <h2>Please choose whether you're an Admin or a Random-User and log-in with your account to test your skills! </h2>
        </div>
        <form action="loginScreen" method="POST">

            <label>Admin or User:</label> 
            <select name="choose">
                <option>Admin</option>
                <option> Random-User</option>
            </select><br><br>
            <label>Username:</label> <input class="write" type="text" name="username"> <br><br>
            <label>Password: </label><input class="write" type="password" name="password"><br><br>
            <input id="login" type="submit" name="logIn" value="Log in"><br><span><?php echo $text ?></span>

        </form>
    </div>
</body>

</html>