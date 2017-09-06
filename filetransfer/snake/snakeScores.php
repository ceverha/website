<?php
	$score = $_GET['score'];
	$name = $_GET['name'];
	
	mysql_pconnect("localhost", "jackceve_admin", "554477");
    mysql_select_db("jackceve_gameone");

    $sql = "INSERT INTO scores (score,name,timestamp) VALUES ($score,'$name',default)";
    if($score >= 0 && $score <=500)
    	mysql_query($sql);
    
?>