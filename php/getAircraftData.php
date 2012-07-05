<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$request = $_POST["request"];
		$data = "";
		
		$con = connect($flight);
		
		$query = "SELECT * FROM seconds WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		$times = array();
		while($result = $statement->fetchObject())
			array_push($times, $result->mid_utc);
		
		$query = "SELECT $request,mid_utc FROM location WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		while($result = $statement->fetch())
			if(in_array($result["mid_utc"], $times))
				$data .= $result["$request"] . ",";
		
		if($data == "")
			throw new Exception("@$request data not present");
		
		echo $data;
	}
	catch(PDOException $e)
	{
		echo "!" . $e->getMessage();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
?>
