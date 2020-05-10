<?php
namespace Model;
use \DB;
class DRGModel extends \Model {
	public static function read_drgs() {
		return DB::query('SELECT DISTINCT id, drg_definition FROM drg ORDER BY id', DB::SELECT)->execute()->as_array();
    }
    public static function get_hospitals($drg) {
		return DB::query("SELECT DISTINCT drg_id, drg.drg_definition, average_covered_charges, average_total_payments, average_medicare_payments, hospital.name, hospital.state, hospital.id FROM financials INNER JOIN hospital ON financials.hospital_id = hospital.id INNER JOIN drg ON financials.drg_id = drg.id WHERE drg_id=$drg", DB::SELECT)->execute()->as_array();
	}
	
}
?>