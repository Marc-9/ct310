<?php
namespace Model;
use \DB;
class HospitalModel extends \Model {
	public static function read_hospital() {
		return DB::query('SELECT DISTINCT `provider_id`,`provider_name`,`provider_state` From hospital_data ORDER BY `provider_id`', DB::SELECT)->execute()->as_array();
    }
}
?>