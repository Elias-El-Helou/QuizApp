<?php
session_start();
if ($_SESSION["username"]=="" || $_SESSION["password"]=="") {
          
    echo "<script>alert('You Have To Login First!');</script>";
    header("Location:loginScreen.php");
};  
$language=$_SESSION['lang'];
$userId=$_SESSION["id"] ;
$level=$_SESSION['lev'];
$idLanguage=$_SESSION['idLanguage'];
$date=date("y-m-d");
?>

<html>

<head>
    <script>
        window.addEventListener('load', function () {
            var div0=document.getElementById("div0");
            div0.style.display = 'block';
            });
            function showNext(i){
                var j=i+1;
                document.getElementById("div"+i).style.display="none";
                
                document.getElementById("div"+j).style.display = 'block';
                return false;
            }
            
    </script>
    <title>Quiz</title>
    <style>
         body {
            background-color: rgb(19, 0, 94);
            text-align: center;
            padding-top: 5px;
        }
        .div {
            padding-top: 5%;
            margin: auto;
            margin-top:30px;
            background-color:black;
            border-radius: 12px;
            text-align: center;
            width: 60%;
            height: 80%;
            background-image: url("images/exam.jpg");
            overflow-x: hidden;
            overflow-y: auto;
        }
        h1{ margin-top: 1px;
            background-color: lightgray;
            font-family: monospace;
            border-radius: 13px;
        }
        h2{
            background-color: lightgray;
            font-family: monospace;
            border-radius: 13px;
            text-align: left; 
        }
        span {
            font-size: 27px;
            font-weight: bold;
            color:black;
            font-family: 'Courier New', Courier, monospace;
        }
        .responses{
            font-size: 20px;
            font-family: 'Courier New', Courier, monospace;
        }
        .s {
            background-color: darkgrey;
            border: 1px solid;
            border-radius: 7px;
            padding: 12px 22px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            font-weight: bold;
            color: rgb(19, 0, 94);
        }

        .s:hover {
            background-color: rgb(19, 0, 94);
            color: white;
        }
        .quest{
            border:3px dashed rgb(19, 0, 94);
            border-radius:8px;
            width:90%;
            margin:auto;
            margin-top:100px;
            padding:10px;
        }
        table{
            margin:auto;
            border-spacing: 20px;
        }
    </style>
</head>

<body>
    <?php
    $nbquestion="";
    $n="";
        $link = mysqli_connect('localhost', 'root', '',  "web_quiz") or
        die(mysqli_connect_errno() . " : " . mysqli_connect_error());
    echo "<div class='div'>
            <form action='quiz.php' method='POST'>";
            
    
    echo "<h1 class='title'> Language: ".$language.", Level: ". $level."</h1>";
    $note=0;
    $nbquestion="";$nbquestion0="";
    $nbquestion1="";$nbquestion2="";
    $nbquestion3="";$nbquestion4="";
function makeNewDiv($i){
    $j=0;
    global $link, $language,$level,$nbquestion,$nbquestion0,$nbquestion1,$nbquestion2,$nbquestion3,$nbquestion4;
    $div="";
    $div.="<div class='quest' style=\"display:none;\" id=\"div$i\">";
    $query = mysqli_query($link,"select nbquestion, given from question NATURAL JOIN language where languagename='$language' and level='$level' order by RAND()");
   
    $line=mysqli_fetch_row($query);
    $div.="<h2 class='title'>Question ".($i+1).": $line[1]</h2><br><br>";

   $nbquestion=$line[0];
            if($i==0){$nbquestion0=$nbquestion;}
            if($i==1){$nbquestion1=$nbquestion;}
            if($i==2){$nbquestion2=$nbquestion;}
            if($i==3){$nbquestion3=$nbquestion;}
            if($i==4){$nbquestion4=$nbquestion;}
    $que=mysqli_query($link,"select text, nbresponse  from response where nbquestion='$nbquestion'");//to get the number of answers for a certain
    $div.="<table>";
    if (mysqli_num_rows($que) > 0) {
        while ($line = mysqli_fetch_assoc($que)) {
            $div.="<tr>";
            $n="in". $i . $j;
            $div.="<th class='responses'>". $line['text']. "&emsp;</th><td><input type='radio' name='".$n. "' value='". $line['nbresponse'] ."'></td>";
            $j++;
        }
    }
    $div.="</table>";
        if($i<4){
        $div.="<br><br><br><button onclick=\"return showNext($i);\" class='s' id=\"btn$i\">Next</button></div>";
        }
        else{
            $div.="<br><br><br><input type='submit' name=\"submit\" class='s' id=\"btn$i\" value='Submit'></div>";
        }
            return $div; 
        } 
       
        for($d=0;$d<5;$d++){
           echo makeNewDiv($d);
        }
      
       echo "</form></div>";

    if(isset($_POST['submit'])){
        
        for($j=0;$j<5;$j++){

            if($j==0){$quest=$nbquestion0;}
            if($j==1){$quest=$nbquestion1;}
            if($j==2){$quest=$nbquestion2;}
            if($j==3){$quest=$nbquestion3;}
            if($j==4){$quest=$nbquestion4;}

            $query=mysqli_query($link,"select nbresponse from response where correct='1' and nbquestion='".$quest."'");
            $row=mysqli_fetch_assoc($query);
            $res=$row['nbresponse']; //Number of the correct answer

            $que=mysqli_query($link,"select count(nbresponse) from response where nbquestion='".$quest."'");
            //To find the number of answers of a certain question
            $line=mysqli_fetch_row($que);
            $nbr=$line[0];
        for($i=0 ; $i < $nbr ; $i++){

            $n="in".$j . $i;
            if(isset($_POST["$n"])){
                if($_POST["$n"]==$res){

                $note=$note+1;
                    }
                }
            }
        }
    //         while ($line = mysqli_fetch_assoc($que)) {
                
    //         $res=mysqli_query($link,"select correct from response where nbresponse= '". $_POST["$n"]. "'");
    //                 if($line['correct']==1){
    //                     $note++;
    //             }
            
    //         }
                
            
        
    
        mysqli_query($link,"insert into test(note, datetest, languageid, level, userid) values('$note' , '$date' , '$idLanguage', '$level', '$userId')");
        echo"<script>alert('Your note is: ". $note ."/5 Tap the OK Button to leave your page safely!');";
        echo "window.location.href = 'loginScreen.php'</script>";
    }

    ?>

    </body>

</html>