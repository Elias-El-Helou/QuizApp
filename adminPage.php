<?php
    session_start();
?>
<html>
<head>
    <?php
    $language="";
    $level="";
    $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
            die(mysqli_connect_errno() . " : " . mysqli_connect_error());
    if ($_SESSION["username"]=="" || $_SESSION["password"]=="") {
          
        echo "<script>alert('You Have To Login First!');</script>";
        header("Location:loginScreen.php");
    };  
    if ( (isset($_POST['submit'])) && (isset($_POST['given']))) {

        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
        $id = $_SESSION["id"];

        $given = $_POST['given'];

        $language = $_POST['lang'];
        
        $idlang = mysqli_query($link, "select languageid from language where languagename= '$language ' ");
        $line2 = mysqli_fetch_row($idlang);
        $languageid = $line2[0];

        $level = $_POST['level'];
        mysqli_query($link, "insert into question (given,level,languageid,idadmin) values('$given',$level,$languageid,$id)");

        if( (isset($_POST['answers'])) ){
        $responseRadio = $_POST['answers']; //return the value of the selected radio
        
        $answer = "response" . $responseRadio; //This the name of the correct answer in the textarea
        $responseCorrect = $_POST[$answer]; //The value of the correct answer in the textarea
        $numResponses = $_POST['howManyAnswers']; //Returns the selected number in the answers

        for ($i = 0; $i < $numResponses; $i++) {
            $answerToEnter = $_POST['response' . $i]; //The value of each answer
            if ($answerToEnter == $responseCorrect) {
                $correct = 1;
            } else {
                $correct = 0;
            }

            $latestQuestion = mysqli_query($link, "select max(nbquestion) from question ;"); //to search for the last quest
            $line = mysqli_fetch_row($latestQuestion);
            $latest = $line[0];

            mysqli_query($link, "insert into response (text, correct, nbquestion) values ('$answerToEnter' , $correct , $latest)");
        }
    }
    else{
        echo "<script>alert('You have to choose the right answer!');</script>";
    }
}

    ?>
    <title>Admin</title>
    <style>
        body {
            background-color:rgb(19, 0,94);
            text-align: center;
            padding-top: 5px;
            color: white;
        }

        .inputButton {
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            font-weight: bold;
            color: white;
        }

        .inputButton2 {
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            font-weight: bold;
            color: white;
        }

        .div {
            padding-top: 1%;
            margin: auto;
            border-radius: 12px;
            text-align: center;
            width: 60%;
            height: 95%;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: lightgray;
            background-image: url("images/adminBackground.png");

        }

        label {
            font-size: 27px;
            font-family: 'Courier New', Courier, monospace;
        }

        .inputButton:hover {
            background-color: darkgrey;
            color: rgb(19,0,94);
        }

        .inputButton2:hover {
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }

        textarea {
            border-radius: 6px;
            border: dashed 3px rgb(19, 0, 94);
        }

        select {
            border-radius: 6px;
            background-color: rgb(19, 0, 94);
            color: white;
            border: 1px solid;
            font-size: 25px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }

        .span {
            font-size: 20px;
            background-color: rgb(19, 0, 94);
            color: white;
            font-weight: bold;
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
    <script>
        var divresponses = document.getElementById('answerCount').value;
        
        function validateFields(){
            if(document.getElementById("given").value.trim()==""){
                document.getElementById("warning").innerHTML="You Have To Write A Question!";
                return false;
            }
            var chosen=false;
            for (var i=0;i<divresponses;i++){
                if(document.getElementById("response"+i).value.trim()==""){
                    document.getElementById("warning").innerHTML="You Have To Write All Answers!";
                    return false;
                }
                if(document.getElementById("radio"+i).checked){
                    chosen=true;
                }
            }
            if(chosen==false){
                document.getElementById("warning").innerHTML="You Have To Choose The Right Answer!!";
                return false;
            }
        }

        function addAnswers() {
            divresponses = document.getElementById('answerCount').value;
            var code = '';
            for (var i = 0; i < divresponses; i++) {
                code += ' <textarea id="response' + i + '" name= "response' + i + '">  </textarea>';
                code += ' <input id="radio'+i+'" type="radio" name="answers" value="' + i + '" > <br><br>';
            }
            code += '<input type="submit" onclick="return validateFields();"';
            code += 'class="inputButton2" name="submit" value="Submit Answers" >';
            document.getElementById("answersDiv").innerHTML = code;
        }
    </script>
</head>

<body>
    <?php
    if (isset($_POST['modifier'])) {
        

        $language = $_POST['lang'];
        $_SESSION['lang']=$_POST['lang'];
        $_SESSION['lev']=$_POST['level'];
        header("Location:editPage.php");
    }
    ?>
    <div class="div">
        <form action="adminPage.php" method="POST">
            <input class="inputButton" type="submit" name="add" value="Tap Here To Add A New Question">
            <br><br>
            
     <div class="choose">
     
    <?php
     
     echo  "<span class='span'>Choose The Programming Language-></span>
     <select name='lang'>";
     $que = "select languagename from language";
     $languages = mysqli_query($link, $que);
     if (mysqli_num_rows($languages) > 0) {
         $x = 0;
         while ($line = mysqli_fetch_row($languages)) {
          echo "<option>" . $line[$x] . "</option>";
               };
             }
         ?>
     </select>
            <span class='span'>Choose The Level-></span>
                    <select name='level'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                    </select> </br></br>
                </div>
            <div class='QA'></div>
 <?php
    if (isset($_POST['add'])) {
         echo " <span class='span' >Number Of Answers-></span>
                <span>
                <select name='howManyAnswers' id='answerCount' onchange='addAnswers()' > 
                    <option value='3'> 3 </option>
                    <option value='4'> 4 </option>
                    <option value='5'> 5 </option>
                </select>

                <span class='span'>Type Your Question-></span>

                <textarea rows='4' cols='30' placeholder='Type Your Question Here' id='given' 
                          name='given' > </textarea><br>
                <input class='inputButton2' type='button' name='done' 
                       value='+Add Answers' onclick='addAnswers()' >

                </span>

                <div id='answersDiv'> </div>
                <h3 id='warning' style=\"color:tomato; 
                    font-family:'Courier New', Courier, monospace; 
                    margin:auto;\">
                </h3>";}
            ?>

            <p style='font-family: \"Courier New\", Courier, monospace;
                    font-size: 15px;font-weight:bold; color:rgb(9,150,0);'>
                Tap On The Button Below<br> To Edit All The Questions <br>
                Of The Selected Language And Level
            </p>
            
            <input class='inputButton' type='submit' name='modifier' value='Edit Your Questions'>
            </form>"
         
        
                       
</div>
</body>

</html>