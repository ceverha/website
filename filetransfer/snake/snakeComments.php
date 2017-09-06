<?php
	$comment = $_GET['comment'];
	
	mysql_pconnect("localhost", "jackceve_admin", "554477");
    mysql_select_db("jackceve_gameone");
	
	$sql = "INSERT INTO Comments (commenttext,timestamp) VALUES ('$comment',default)";
    mysql_query($sql);
    
?>