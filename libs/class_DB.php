<?php
/*
РОБОТА З ОБЄКТОМ ВИБОРКИ
$res = q(); // Запрос з возвратом результатів
$res->num_rows; //Кількість повернутих строк - mesqli_num_rows();
$res->fetch_assoc(); //достаємо запис mysqli_fetch_assoc();
$res->close(); // Очищуєм результат вибірки

РОБОТА С ПОДКЛЮЧЕНОЮ MYSQL
DB::_()->affected_rows; // Кількість змінених записей
DB::_()->insert_id; // Останій ID вставки
DB::_()->query; // аналог q
DB::_()->multi_query(); // кількісний запрос
DB::_()->real_escape_string(); // аналог mres();
DB::close(); // закриваєм звязок з БД
*/

class DB {
	static public $mysqli = array();
	static public $connect = array();
	
	static public function _($key = 0) {
		if(!isset(self::$mysqli[$key])) {
			if(!isset(self::$connect['server'])){
				self::$connect['server'] = Core::$DB_LOCAL;
			}
			if(!isset(self::$connect['user'])){
				self::$connect['user'] = Core::$DB_LOGIN;
		    }
			if(!isset(self::$connect['pass'])){
				self::$connect['pass'] = Core::$DB_PASS;
			}
			if(!isset(self::$connect['db'])){
				self::$connect['db'] = Core::$DB_NAME;
			}

			self::$mysqli[$key] = @new mysqli(self::$connect['server'],self::$connect['user'],self::$connect['pass'],self::$connect['db']); // WARNING
			if (mysqli_connect_errno()) {
				echo 'Не вдалось підключитись до БД';
				exit();
			}
			if(!self::$mysqli[$key]->set_charset("utf8")) {
				echo 'Ошибка при загрузці набора символів utf8:'.self::$mysqli[$key]->error;
				exit();
			}
		}
		return self::$mysqli[$key];
	}
	static public function close($key = 0) {
		self::$mysqli[$key]->close();
		unset(self::$mysqli[$key]);
	}
}