<?php
	include_once("./mysql.php");
	
	try
	{
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		
		$query = "SELECT * FROM location WHERE mid_utc = ?";
		$param = array($_POST["time"]);
		$statement = $con->prepare($query);
		$statement->execute($param);
		
		$result = $statement->fetchObject();
		
		if(!$result)
			throw new Exception("!Location table is empty!");
		
		$data .= (float)$result->lat_deg . ",";
		$data .= (float)$result->lat_min . ",";
		$data .= (float)$result->lat_sec . ",";
		$data .= (float)$result->lon_deg . ",";
		$data .= (float)$result->lon_min . ",";
		$data .= (float)$result->lon_sec . ",";
		$data .= $result->gps_altitude . ",";
		$data .= $result->static_air_pres . ",";
		$data .= $result->static_air_temp . ",";
		$data .= $result->dew_point_temp . ",";
		$data .= $result->cn_greater_10nm . ",";
		
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
