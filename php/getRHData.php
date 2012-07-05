<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		
		$query = "SELECT rhInlet FROM scat_coefficient WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		$data = "";
		
		while($result = $statement->fetchObject())
			$data .= $result->rhInlet . ",";
		
		if($data == "")
			throw new Exception("@Relative Humidity data could not be loaded!");
		
		$query = "SELECT rhChamber FROM scat_coefficient WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		$data .= "+";
		
		while($result = $statement->fetchObject())
			$data .= $result->rhChamber . ",";
	
		$query = "SELECT rhOutlet FROM scat_coefficient WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		$data .= "+";
		
		while($result = $statement->fetchObject())
			$data .= $result->rhOutlet . ",";
		
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
