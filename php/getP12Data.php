<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT * FROM p12 WHERE mid_utc = ?";
		$param = array($_POST["time"]);
		$statement = $con->prepare($query);
		$statement->execute($param);
		$result = $statement->fetch();
		
		if(!$result)
			throw new Exception("@P12 data couldn't be found!");
		
		for($i = 3; $i <= 176; $i++)
			$data .= $result["degree".$i] . ",";
		
		echo $data;
	}
	catch(PDOException $e)
	{
		echo ("!" . $e->getMessage());
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
?>
