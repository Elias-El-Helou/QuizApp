<?php session_start();
    if ($_SESSION["username"]==="" || $_SESSION["password"]==="") {
        header("Location:loginScreen.php");
        echo "<script>alert('You Have To Login First!');</script>";
        
    }; 
      $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
      die(mysqli_connect_errno() . " : " . mysqli_connect_error());
      
?>
<html>
<head>
    <title>Take Your Test</title>
    <style>
        body{
            background-color: rgb(19, 0, 94);
        }
        .div{
            padding-top: 5%;
            margin: auto;
            margin-top:50px;
            background-color:lightgrey;
            background-image: url("images/testBackground.png");
            border-radius: 12px;
            text-align: center;
            width: 60%;
            height: 80%;
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
        .input{
            background-color: rgb(19, 0, 94);
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            font-weight: bold;
            color: white;
        }
        .input:hover{
            background-color: darkgrey;
            color: rgb(19, 0, 94);
        }
        span{
            border:2px darkgrey dashed;
            color:white;
            font-weight:bold;
            font-size:25px;
            background-color: rgb(19, 0, 94);
            font-family:'Courier New', Courier, monospace;
        }
        h1 {
            background-color: lightgray;
            font-family: monospace;
            border-radius: 13px;
            text-align: center;
            color: rgb(19, 0, 94);
            font-weight: bolder;
            background-color: darkgray ;
        }
    </style>
</head>

<body>
    
    <div class="div">
        <h1>Choose Your Language And Your Level To Start Your Test!</h1>
        <form action="userPage.php" method="POST">

            <span class='span'>Choose The Programming Language-></span>
            <select name='language'>
            <?php
            
            $que = "select languagename from language";
            $languages = mysqli_query($link, $que);
            if (mysqli_num_rows($languages) > 0) {
                $x = 0;
                while ($line = mysqli_fetch_row($languages)) {
                    echo "<option>" . $line[$x] . "</option>";
                };
            }
            ?>
            </select><br> <br><br>  <br><br>    <br><br><br> 

            <span class='span'>Choose The Level-></span>
                    <select name='level'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                    </select> <br><br> <br> <br><br><br> <br> <br>
            <input type='Submit' value='Start Your Test!' name='submit' class='input'>
            <input type='Submit' value='View Previous Results!' name='print' class='input'>

            <?php
            
            if(isset($_POST['print'])){
                header("Location:results.php");
            }
            if(isset($_POST['submit'])){
                
            $language=$_POST['language'];
            $level=$_POST['level'];
            $userId=$_SESSION["id"] ;
            $_SESSION['lang']=$language;
            $_SESSION['lev']=$level;
            $limit=3;
            $resultt=mysqli_query($link,"select languageid from language where languagename='$language'" );
            $row=mysqli_fetch_row($resultt);
            $idLanguage=$row[0];
            $_SESSION['idLanguage']=$idLanguage;
            $prevLevel=$level - 1;
            
            if($level>1){
                $res=mysqli_query($link,"select count(*) from test where userid = '$userId' and level = $prevLevel and note >  $limit  and languageid=  $idLanguage");
                $line=mysqli_fetch_row($res);
                if($line[0]==0){
                    echo "<script>alert('You have to get at least (4/5) in the previous level') </script>";
                }
                else{
                    header("Location:quiz.php");
                   }
                }
            else header("Location:quiz.php");
            }
            ?>
            
        </form>
    </div>
</body>

</html>