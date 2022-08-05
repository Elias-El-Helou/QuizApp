<?php
 $link = mysqli_connect('localhost', 'root', '') or 
       die(mysqli_connect_errno()." : ".mysqli_connect_error());
       mysqli_query($link, "create database web_quiz") 
         or die(" Error in creating the data base");
       mysqli_select_db($link, 'web_quiz')or die("Error in selection of the data base");
 
       $query = "create table user(userid int primary key, ";
	   $query .= " name varchar(15) not null, lastname varchar(15) not null, "; 
	   $query .= " username varchar(8) not null, password varchar(8) not null)";
	   mysqli_query($link, $query);
	   
       $query = "create table admin(idadmin int primary key, ";
	   $query .= " name varchar(15) not null, lastname varchar(15) not null, "; 
	   $query .= " username varchar(8) not null, password varchar(8) not null)";
	   mysqli_query($link, $query);
	   
	   $query = "create table language(languageid int primary key, ";
	   $query .= " languagename varchar(15) not null)"; 
	   mysqli_query($link, $query);
	   
	   $query = "create table question(nbquestion int auto_increment primary key, ";
	   $query .= " given varchar(60) not null, level tinyint(1) not null, ";
	   $query .= " languageid int not null references language (languageid), "; 
	   $query .= " idadmin int not null references admin(idadmin))";
	   mysqli_query($link, $query);

	   $query = "create table response(nbresponse int auto_increment primary key, ";
	   $query .= " text varchar(60) not null, correct boolean not null, ";
	   $query .= " nbquestion int not null references question (nbquestion)) "; 
	   mysqli_query($link, $query);


	   $query = "create table test(nbtest int auto_increment primary key, ";
	   $query .= " note tinyint(1) not null, datetest date not null, ";
	   $query .= " languageid int not null references language (languageid), "; 
	   $query .= " level tinyint(1) not null, userid int not null references user(userid))";
	   mysqli_query($link, $query);


	   mysqli_query ($link, "insert into language values(1, 'HTML')");
	   mysqli_query ($link, "insert into language values(2, 'JavaScript')");
	   mysqli_query ($link, "insert into language values(3, 'PHP')");
	  

	  mysqli_query ($link, "insert into admin values(1, 'Karim', 'Karam', 'admin1', 'admin1')");
	  mysqli_query ($link, "insert into admin values(2, 'Salim', 'Salem', 'admin2', 'admin2')");

	 
	  mysqli_query ($link, "insert into user values(1, 'Rim', 'Karam', 'user1', 'user1')");
	  mysqli_query ($link, "insert into user values(2, 'Sami', 'Sam', 'user2', 'user2')");
      mysqli_query ($link, "insert into user values(3, 'Joe', 'Fadi', 'user3', 'user3')");
	  mysqli_query ($link, "insert into user values(4, 'Kamil', 'Kim', 'user4', 'user4')");

	  mysqli_query ($link, "insert into question (given,level,languageid,idadmin) values('HTML stands for', 1, 1, 1)");
	  mysqli_query ($link, "insert into question (given,level,languageid,idadmin) values('The script tag should be written in', 1, 1, 1)");
	  mysqli_query ($link, "insert into question (given,level,languageid,idadmin) values('the body is above the head', 1, 1, 1)");
	  mysqli_query ($link, "insert into question (given,level,languageid,idadmin) values('A table should contain', 1, 1, 1)");
	  mysqli_query ($link, "insert into question (given,level,languageid,idadmin) values('the ul tag means', 1, 1, 1)");

	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('Hyper Text Markup Language', 1, 1)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('Hyper Protocol Markup Language', 0, 1)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('Hyper Text Modern Language', 0, 1)");

	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('header', 0, 2)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('body', 0, 2)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('anywhere', 1, 2)");

	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('true', 0, 3)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('false', 1, 3)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('does not matter', 0, 3)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('It depends', 0, 3)");

	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('only tr', 0, 4)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('only td', 0, 4)");	  
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('both', 1, 4)");

	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('ordered list', 0, 5)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('unified list', 0, 5)");
	  mysqli_query ($link, "insert into response (text, correct, nbquestion) values('unordered list', 1, 5)");
	
	  echo "db created";
	  mysqli_close($link);	  
?>