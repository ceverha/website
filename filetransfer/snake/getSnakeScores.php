<?php
	
	mysql_pconnect("localhost", "jackceve_admin", "554477");
    mysql_select_db("jackceve_gameone");

        $sql = "SELECT * FROM scores ORDER BY score DESC";
	$result = mysql_query($sql);
	$limiter = 0;
	$limit = 15;
	?>
	<h1>SNAKE: The Leaderboard</h1>
	<table>
	<tr>
	<td>Name</td>
	<td>Score</td>
	<td>Timestamp</td>
	<tr/>
	<?php
	while ($row = mysql_fetch_array($result)){
		if ($limiter < $limit){
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
			$limiter = $limiter + 1;
		}
	}
	?>

	</table>
	<span id="link">Want to see all the scores?<a href="getAllSnakeScores.php">Click Here</a></span><br/>
	<?php
	$sql = "SELECT COUNT(*) as \"count\" from scores";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)){
		echo $row['count'] . " total scores submitted";
	
	}
	?>
	<br/>
	<br/>
	<div id="changelog">
		<span style="font-size:14px">Change Log</span><br/><br/>
		4-28-2014 Eating a cookie now results in three blocks to be added<br/>
		4-28-2014 The score table updates only every three seconds, in case of lag<br/>
		4-28-2014 Two cookies now exist at a time<br/>
		4-30-2014 Comment box added
	</div>


	


    