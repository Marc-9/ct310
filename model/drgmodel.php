<?php
namespace Model;
use \DB;
class DRGModel extends \Model {
	public static function read_drgs() {
		return DB::query('SELECT DISTINCT drg_Number, drg_definition From hospital_data ORDER BY `drg_Number`', DB::SELECT)->execute()->as_array();
    }
}
?>