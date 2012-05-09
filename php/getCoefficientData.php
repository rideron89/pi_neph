<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT * FROM scat_coefficient WHERE mid_utc = ?";
		$param = array($_POST["time"]);
		$statement = $con->prepare($query);
		$statement->execute($param);
		
		$result = $statement->fetchObject();
		
		$data .= $result->start_utc . ",";
		$data .= $result->end_utc . ",";
		$data .= $result->mid_utc . ",";
		$data .= $result->hh_utc . ",";
		$data .= $result->mm_utc . ",";
		$data .= $result->ss_utc . ",";
		$data .= $result->scat . ",";
		$data .= $result->pressure . ",";
		$data .= $result->rhInlet . ",";
		$data .= $result->rhChamber . ",";
		$data .= $result->rhOutlet . ",";
		$data .= $result->temperature . ",";
		
		echo $data;
	}
	catch(PDOException $e)
	{
		echo ("!" . $e->getMessage());
	}
?>
