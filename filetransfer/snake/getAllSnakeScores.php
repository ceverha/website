<?php
	
	mysql_pconnect("localhost", "jackceve_admin", "554477");
    	mysql_select_db("jackceve_gameone");

    
    	$sql = "SELECT * FROM scores ORDER BY score DESC";
	$result = mysql_query($sql);
	
	?>
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<style>
		*{
			font-family: 'Montserrat', sans-serif;
		}
	</style>
	<table>
	<tr>
	<td>Name</td>
	<td>Score</td>
	<td>Timestamp</td>
	</tr>
	<?php
	while ($row = mysql_fetch_array($result)){
		
		echo '<tr>';
		echo '<td>'; 
		echo $row['name']; 
		echo '</td>';
		echo '<td>'; 
		echo $row['score'];
		echo '</td>';
		echo '<td>';
		echo $row['timestamp'];
		echo '</td>';
		echo '</tr>';
		
		
	}
	?>

	</table>
	<span id="link">Back to the Game<a href="snake.php">Click Here</a></span>
    