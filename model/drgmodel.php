<?php
namespace Model;
use \DB;
class DRGModel extends \Model {
	public static function read_drgs() {
		return DB::query('SELECT drg_Number, drg_definition FROM `hospital_data` LIMIT 100', DB::SELECT)->execute()->as_array();
    }
}
?>