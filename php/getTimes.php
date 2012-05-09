<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT * FROM seconds WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		while($result = $statement->fetchObject())
		{
			$data .= $result->mid_utc . ",";
		}
		
		echo $data;
	}
	catch(PDOException $e)
	{
		echo "!" . $e->getMessage();
	}
?>
