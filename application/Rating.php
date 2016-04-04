<?php
/*
 *Author: M-M T
 *Hindamis klass. Rakenduse põhiloogika asub siin
 *
 */
class Rating {

	public $r;
	public $ip;
	public $b;
	public $array = array();

	//Konstruktor mis laeb andmebaasi objekti antud faili
	function __construct() {

		$this -> db = new Database();

	}

	//Kas id mida päritakse on õige ja pole tühi
	public function idControl() {

		if (isset($_GET['id']) && !empty($_GET['id'])) {
			return $_GET['id'];

		}

	}
	
	public function ipFunc(){
		
		$ip = $_SERVER['REMOTE_ADDR'];
			return $ip;
		
	}

	//Funktsioon mis kontrollib kas ip on baasis
	public function ipCheck() {
		$id = $this -> idControl();
		$this -> ip = ',' . $this -> ipFunc();
		$q = $this -> db -> prepare("select ip from ratings where id='$id'");
		$q -> execute();
		$this -> r = $q -> fetch(PDO::FETCH_ASSOC);

		//print_r($this->r);

		$arr = array();
		if (is_array($this -> r)) {
			foreach ($this->r as $value) {

				$arr[] = $value;
			}
		}

		$str = implode(',', $arr);
		//echo $str;
		$this -> array = explode(',', $str);

		$this -> b = str_replace(',', '', $this -> ip);
		$array2 = array_shift($this -> array);

		if (in_array($this -> b, $this -> array)) {

			return false;

		} else {

			return true;
		}

		return $this -> array;
	}

	//Näitame postitusi ja hindamis vormi kasutajatele
	public function index() {
		$ip = $this -> ipFunc();
		$sth = $this -> db -> prepare("SELECT  *
				    FROM posts 
				    INNER JOIN ratings ON (
				    ratings.posts_id = posts.id
                           );");

		$sth -> execute();
		$result = $sth -> fetchAll();

		foreach ($result as $key => $value) {
			echo "<div class='content'>";
			echo '<h2>' . $value['title'] . '</h2>' . "\n";
			echo '<p>' . $value['content'] . '</p>' . "\n";
	
			$current = $value['rate'] / $value['votes'];
				
			echo '<hr>';
			echo '<div id="stats">';
			echo '<b>Hinne: </b> ' . round($current, 1) . ' <span class="vertical-line">|</span> ';
			echo '<b>Hinnatud: </b> ' . $value['votes'] . 'x' . '<br>';
			echo '</div>';
			$id = $value['id'];
			$ip = $value['ip'];

		

			 $arr = explode(',', $ip);

            if (in_array($this->ipFunc(), $arr)) {

				echo '<div class="voted">Oled seda postitust hinnanud.</div>';
			} else {
		
				require 'templates/forms/form.php';

			}
			
			echo '</div>' . "\n";
		}

	}

	//Postitame hääle baasi ,kui IP veel baasis ei ole

	public function vote() {
					
		$id = $this -> idControl();
		
		$this -> ip = ',' . $this -> ipFunc();
		
			$voted = $_POST['r'];
		
				if(!isset($voted)) {
					
					header('location:index.php?url=error');
					echo 'Bad';
					die();
				}
		
		
		
			if (!$this -> ipCheck()) {
               //Kui ip eksisteerib siis ei lase mingit moodi postitada baasi. 
                //IP on olemas sõnum on rohkem Debug message. Võib vabalt välja kommenteerida
				echo 'Bad';
				return false;
				
			} else {
			
				$sth = $this -> db -> prepare("update ratings set rate = rate + $voted,ip=concat(ip,'$this->ip'), votes = votes+1  where id='$id'");
				$sth -> execute(array($voted));
				  //Kui läbi IP kontrolli ja midagi muud valesti ei läinud näitame sõnumit. Sõnum asub Init.php failis
				header('location:index.php?url=saved');
		}
	}

}//Klass
