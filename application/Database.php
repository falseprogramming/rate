<?php

/*
 * Andmebaasi klass mis laiendab PDO PHP andmebaasi objekti
 * Rohkem infot leiab seal: http://php.net/manual/en/book.pdo.php
 * Ühenduse konstantid asuvad config/config.php failis
 * 
 */

class Database extends PDO {
		
	//Teeme ühenduse konstruktor funktsioonis. Kui midagi läks valesti , siis näitame vastavat errorit.
	//Siin püüame ainult ühenduse errorit
	function __construct() {
		
		try {
			parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		} catch(PDOException $e) {

			echo '[ ANDMEBAASI ] Error!' . $e -> getMessage();
		}

	}

}
