<?php
	/*Parsing VMZ data into more useful structures
	Author(s)		: Lukas Mirow
	Date of creation	: 6/15/2019
	*/

	class VmzIncident
	{
		public $type;
		public $state;
		public $street_names;
		public $valid_from;
		public $valid_to;
		public $description;
		public $section;
		public $latitude;
		public $longitude;


		public static function conv_time($string)
		{
			$expir = strtotime($string);
			if ($expir == false)
				return PHP_INT_MAX;
			else
				return $expir;
		}

		function __construct($incident_root)
		{
			if (property_exists($incident_root, "name"))
			{
				$this->type = $incident_root->name;
			}
			if (property_exists($incident_root, "address") and property_exists($incident_root->address, "state"))
			{
				$this->state = $incident_root->address->state;
			}
			if (property_exists($incident_root, "streets"))
			{
				$this->street_names = $incident_root->streets;
			}
			if (property_exists($incident_root, "validities"))
			{
				foreach ($incident_root->validities as $validity)
				{
					if ($validity->visible == 1)
					{
						if (property_exists($validity, "timeFrom"))
						{
							$this->valid_from = VmzIncident::conv_time($validity->timeFrom);
						}
						if (property_exists($validity, "timeTo"))
						{
							$this->valid_to = VmzIncident::conv_time($validity->timeTo);
						}
						break;
					}
				}
			}
			if (property_exists($incident_root, "description"))
			{
				$this->description = $incident_root->description;
			}
			if (property_exists($incident_root, "section"))
			{
				$this->section = $incident_root->section;
			}
			if (property_exists($incident_root, "location"))
			{
				$this->longitude = $incident_root->location->coordinates[0];
				$this->latitude = $incident_root->location->coordinates[1];
			}
		}
	}
?>
