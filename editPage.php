<?php session_start();?>
<html>

<head>
    <title>Edit your questions</title>
    <style>
        body {
            background-color: rgb(19, 0, 94);
            background-image: url("images/editQuest.jpg");
        }

        div {
            margin-top: 5%;
            border-radius: 6px;
            border: solid 3px;
        }

        .questions {
            position: absolute;
            top: 23px;
            left:15px;
            height: 600px;
            width: 40%;
            border: 5px solid;
            border-color: darkgrey;
            margin-left: 40px;
            background-color: lightgrey;
            background-image: url("images/editQuestions.jpg");
            color: rgb(19, 0, 94);
            overflow-x: auto;
            overflow-y: auto;
        }

        .changes {
            position: absolute;
            top: 90px;
            right: 15px;
            height: 600px;
            width: 50%;
            border: 5px solid;
            border-color: darkgrey;
            margin-left: 40px;
            margin-top: 10px;
            background-color: lightgrey;
            background-image: url("images/questionsBackground.jpg");
            color: rgb(19, 0, 94);
        }

        .buttons {
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .buttons:hover {
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }

        table tr td {
            border-radius: 6px;
        }

        .td {
            color: lightgrey;
            background-color: rgb(19, 0, 94);
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
        }

        #quest {
            font-size: 22px;
            height: 130px;
            width: 95%;
            margin: auto;
            border-radius: 7px;
            border: 2px solid darkgrey;
            background-color: rgb(19, 0, 94);
            color: lightgrey;
            overflow-x: hidden;
            overflow-y: auto;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        #resp {
            height: 400px;
            width: 95%;
            margin: auto;
            border-radius: 7px;
            border: 2px solid darkgrey;
            background-color: rgb(19, 0, 94);
            color: lightgrey;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .resps {
            font-size: 18px;
            height: 50px;
            width: 90%;
            margin: auto;
            border-radius: 7px;
            border: 2px solid darkgrey;
            background-color: rgb(19, 0, 94);
            color: lightgrey;
            overflow-x: hidden;
            overflow-y: auto;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        #submit{
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            font-weight: bold;
            color:<?php echo $color; ?>
        }
        #submit:hover {
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }
        .error{
            color:red;
            font-weight:bold;
            font-family:'Courier New', Courier, monospace;
            font-size:medium;
        }
    </style>
    <script>
        function validate(){
            if(document.getElementById("quest").value.trim()==""){
                document.getElementById("warning").innerHTML="You have to write a question!";
                return false;
            }
            var chosen=false;
            for (var i=0;i< <?php echo $_SESSION['nbr'] ?> ;i++){
                if(document.getElementById("response"+i).value.trim()==""){
                    document.getElementById("warning").innerHTML="You have to write all the answers!";
                    return false;
                }
                if(document.getElementById("radio"+i).checked){
                    chosen=true;
                }
            }
            if(chosen==false){
                document.getElementById("warning").innerHTML="You have to choose the correct answer!";
                return false;
            }
        }
    </script>

</head>

<body>
    <h1>Modify Your Questions Of <?php echo $_SESSION['lang'] ;?>
    Level: <?php echo $_SESSION['lev']; ?>, By Tapping On The Appropriate Button </h1>
    <div class="questions">
        <form action="editPage.php" method="POST">
            <table>
                <?php
                      $color="white";
                     if ($_SESSION["username"]=="" || $_SESSION["password"]=="") {
                         
                       echo "<script>alert('You Have To Login First!');</script>";
                       header("Location:loginScreen.php");
                   };  
                $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
                    die(mysqli_connect_errno() . " : " . mysqli_connect_error());
                $id = $_SESSION["id"];
                $language=$_SESSION['lang'];
                $level=$_SESSION['lev'];
                $query = "select given , languagename , level , nbquestion from question NATURAL JOIN language where idadmin='$id'";
                $query .=" and level='".$level."' and languagename='".$language."'";
                echo "<th>Question Number</th><th> Given </th> <th>Language&Level  </th><th>Nb. Question</th>";
                $res = mysqli_query($link, $query);

                $x = 0;
                if (mysqli_num_rows($res) > 0) {
                    $lines = 0;
                }
                while ($lines = mysqli_fetch_row($res)) {
                    echo "<tr><td class='td'>" . ($x + 1) . ":</td> <td class='td'>" . $lines[0] . "</td><td class='td'>" . $lines[1] . ":" . $lines[2] . "</td>";
                    echo "<td class='td'><input type='submit' class='buttons' name='quest' value=\" $lines[3]\"</td></tr>";
                    $x++;
                }
                
                ?>
            </table>

        </form>
    </div>
    <div class="changes">
        <?php
        $nbquestion="";
        $number=0;
        if (isset($_POST['quest'])) {
            $nbquestion = $_POST['quest'];
            $_SESSION['quest']=$nbquestion;
            $query = "select given from question where nbquestion='$nbquestion'";
            $result = mysqli_query($link, $query);
            $l = mysqli_fetch_row($result);
            $quest = "$l[0]";

            $querynbResponse = "select count(*) from response where nbquestion='$nbquestion'";
            $res = mysqli_query($link, $querynbResponse);
            $line = mysqli_fetch_row($res);
            $number = $line[0];
            $_SESSION['nbr']=$number;
            
            echo "<form action='editPage.php' method='POST'>
                    <textarea id='quest' name='given'>$quest</textarea>
                    <div id='resps'>";
            $queryResponses = "select text from response where nbquestion='$nbquestion'";
            $line = mysqli_query($link, $queryResponses);
            $tableOfResponses = array();
            
            while ($lines = mysqli_fetch_row($line)) {
                $tableOfResponses[] = $lines[0];
            }
                
            foreach($tableOfResponses as $key=>$val) {
                echo "<textarea id='response".$key."' class='resps' name= 'response[]' >$val</textarea>
                          <input id='radio".$key."' type='radio' name='answers' value='" . $key . "' > <br><br>";
            }
            echo "<input type='submit' id='submit' name='submitChanges' onclick='return validate();' value='Submit Changes' >
                    <h3 id='warning' style=\"color:tomato; 
                    font-family:'Courier New', Courier, monospace; 
                    margin:auto;\">
                    </h3>";
            
        }
        if(isset($_POST['submitChanges'])){
            if((isset($_POST['given']))&&isset($_POST['answers'])){
                $given=$_POST['given'];
                $nbquestion=$_SESSION['quest'];
                $responseRadio = $_POST['answers']; //returns the value of the selected radio 
                 
                    mysqli_query($link, "update question set given='$given' where nbquestion='$nbquestion'");
                    $number=$_SESSION['nbr'];
                    $query="select nbresponse from response where nbquestion='$nbquestion'";
                    $res=mysqli_query($link,$query);
                    for ($i = 0; $i < $number; $i++) {
                        if(isset($_POST['response'])){
                         $response=$_POST['response'];
                         $answerToEnter = $response[$i];
                        if ($i == $responseRadio) {
                            $correct = 1;
                        } else {
                            $correct = 0;
                        }
                        $line=mysqli_fetch_row($res);
                        
                        mysqli_query($link, "update response set text='$answerToEnter', correct=$correct  where nbquestion='$nbquestion' and nbresponse='".$line[0]."' ");
                      }  
                        
                    }
                }
                else{
                    
                    echo "<script>alert('You have to choose the right answer') </script>";
                }
            }
        
        ?>

        </form>
    </div>
    
</body>

</html>