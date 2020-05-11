<?php
namespace Model;
use \DB;
class HospitalModel extends \Model {
	public static function read_hospital() {
		return DB::query('SELECT DISTINCT `provider_id`,`provider_name`,`provider_state` From hospital_data ORDER BY `provider_id`', DB::SELECT)->execute()->as_array();
    }
     public static function get_hospitals($id) {
		return DB::query("SELECT DISTINCT drg_id, drg.drg_definition, average_covered_charges, average_total_payments, average_medicare_payments, hospital.name, hospital.state, hospital.id FROM financials INNER JOIN hospital ON financials.hospital_id = hospital.id INNER JOIN drg ON financials.drg_id = drg.id WHERE hospital_id=$id", DB::SELECT)->execute()->as_array();
	}
}
?>
