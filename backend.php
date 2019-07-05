<?php

	define("USER", "your user name here");
	define("PW", "your passphrase here");
	define("HOST", "your host here");
	define("PORT", "your port here");
	define("DDB", "your database here");
	define("INCIDENTS_FILE", "incidents");

	require_once("VmzIncident.php");

	function get_ddb_cursor($user, $pw, $host, $port, $ddb)
	{
		$man = new MongoDB\Driver\Manager("mongodb://$user:$pw@$host:$port");
		$query = new MongoDB\Driver\Query([]);
		return $man->executeQuery($ddb, $query);
	}

	function create_incidents($cur)
	{
		$ret = array();
		$it = new IteratorIterator($cur);
		$it->rewind();
		$counter = 0;
		while ($it->valid() and $counter < 50000)
		{
			if (isset($it->current()->address) and isset($it->current()->address->state))
			{
				if ($it->current()->address->state == "Berlin")
				{
					$counter++;
					echo "Loading file #$counter...\n";
					array_push($ret, new VmzIncident($it->current()));
				}
			}
			$it->next();
		}
		echo "Done\n";
		return $ret;
	}

	function write_incidents($incidents, $fname)
	{
		echo "Writing file to disk...\n";
		file_put_contents($fname, serialize($incidents));
		echo "Done\n";
	}

	write_incidents(create_incidents(get_ddb_cursor(USER, PW, HOST, PORT, DDB)), INCIDENTS_FILE);

?>
