<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$request = $_POST["request"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT $request FROM scat_coefficient WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		while($result = $statement->fetch())
			$data .= $result["$request"] . ",";
		
		echo $data;
	}
	catch(PDOException $e)
	{
		echo "!" . $e->getMessage();
	}
?>
