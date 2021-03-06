<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT * FROM p11 WHERE mid_utc = ?";
		$param = array($_POST["time"]);
		$statement = $con->prepare($query);
		$statement->execute($param);
		$result = $statement->fetch();
		
		if(!$result)
			throw new Exception("@P11 data could not be loaded!");
		
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
