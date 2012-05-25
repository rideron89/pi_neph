<?php
	include_once("./mysql.php");
	
	/*
	 * readFromFile()
	 * 
	 * As a backup measure (database could not be found), read the times from
	 * a text file.
	 */
	function readFromFile($flight) {
		try {
			$flight = $_POST["flight"];
			$filePath = "../$flight/times.ict";

			$file = file_get_contents($filePath);
			
			if(!$file) {
				throw new Exception("!Could not load times!");
			}

			$timesArray = explode("\n", $file);
			$times = "";

			for($i = 0; $i < count($timesArray); $i++)
				$times .= $timesArray[$i] . ",";

			echo "@Read times from backup,";
			echo $times;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	try {
		$flight = "devote_" . $_POST["flight"];
		$data = "";
		
		$con = connect($flight);
		$query = "SELECT * FROM seconds WHERE 1";
		$statement = $con->prepare($query);
		$statement->execute();
		
		while($result = $statement->fetchObject()) {
			$data .= $result->mid_utc . ",";
		}
		
		if($data == "")
			throw new Exception($_POST["flight"]);
		
		echo $data;
	}
	catch(PDOException $e) {
		echo "!" . $e->getMessage();
	}
	catch(Exception $e) {
		readFromFile($e->getMessage());
	}
?>
