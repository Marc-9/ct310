<?php
namespace Model;
use \DB;
class DRGModel extends \Model {
	public static function read_drgs() {
		return DB::query('SELECT DISTINCT drg_Number, drg_definition From hospital_data ORDER BY `drg_Number`', DB::SELECT)->execute()->as_array();
    }
    public static function get_hospitals($drg) {
		return DB::query("SELECT provider_id, provider_name, provider_state, average_covered_charges, average_total_payments, average_medicare_payments, drg_Number, drg_definition FROM hospital_data WHERE drg_Number=$drg", DB::SELECT)->execute()->as_array();
	}
	
}
?>