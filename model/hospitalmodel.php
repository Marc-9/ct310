<?php
namespace Model;
use \DB;
class HospitalModel extends \Model {
	public static function read_hospital() {
		return DB::query('SELECT DISTINCT `provider_name` as name FROM `hospital_data`', DB::SELECT)->execute()->as_array();
    }
}
?>