<html>

<head>
    <title>
        Results
    </title>
    <style>
        table {
            margin: auto;
        }

        table tr td {
            border-radius: 6px;
            text-align:center;
        }

        .td {
            color: lightgrey;
            background-color: rgb(19, 0, 94);
            font-size: xx-large;
            
        }

        h1 {
            background-color: lightgray;
            font-family: monospace;
            border-radius: 13px;
            text-align: center;
            color: rgb(19, 0, 94);
        }

        th {
            background-color: darkgrey;
            font-size: xx-large;
        }

        body {
            background-color: rgb(19, 0, 94);
            text-align: center;
            padding-top: 5px;
        }

        div {
            padding-top: 5%;
            margin: auto;
            background-color: black;
            border-radius: 12px;
            text-align: center;
            width: 60%;
            height: 80%;
            background-image: url("images/resback.png");
            overflow-x: auto;
            overflow-y: auto;
        }

        #in {
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            font-weight: bold;
            color: white;
        }

        #in:hover {
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION["username"]=="" || $_SESSION["password"]=="") {
          
        echo "<script>alert('You Have To Login First!');</script>";
        header("Location:loginScreen.php");
    };  
    $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
        die(mysqli_connect_errno() . " : " . mysqli_connect_error());

    $que = "select username from user where userid='" . $_SESSION['id'] . "'";
    $result = mysqli_query($link, $que);
    $line = mysqli_fetch_row($result);
    echo "<h1>You're Welcome: " . $line[0] . "!</h1>
                 <div>
                    <table>
                    <th>Test Number</th><th> Note Over 5</th> <th>Test Date  </th><th>Language Id</th><th>Test Level</th>";
    $query = "select nbtest, note, datetest, languageid, level from test where userid='" . $_SESSION['id'] . "'";
    $res = mysqli_query($link, $query);

    $x = 0;
    if (mysqli_num_rows($res) > 0) {
        $lines = 0;
    }
    while ($lines = mysqli_fetch_row($res)) {
        echo "<tr><td class='td'>" . $lines[0] . "</td> <td class='td'>" . $lines[1] . "</td><td class='td'>" . $lines[2] . "</td> 
                            <td class='td'>" . $lines[3] . "</td> <td class='td'>" . $lines[4] . "</td></tr>";


        $x++;
    }
    ?>
    </table><br><br>    <br><br>    <br><br>
    <form action="results.php" method="POST">
        <input type="Submit" value="Go Back" name="back" id="in">
    </form>
    <?php
    if (isset($_POST['back'])){
        header("Location:userPage.php");
    }
    ?>
    </div>
    ?>
</body>

</html>