<?php
namespace Model;
use \DB;
class LoginModel extends \Model {
	public static function read_logins() {
		return DB::query('SELECT * FROM `users`', DB::SELECT)->execute()->as_array();
    }
}
?>