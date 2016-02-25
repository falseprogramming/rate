<?php

/*
 * Klass mis jooksutab rakendust läbi url parameetri
 *
 *
 */

class Init {

    //Konstruktor tegeleb antud klassi funktsioonidega. Selle klassi funktsiooid
    //laevad Rating klassist rakenduse põhiloogika sisse.

    function __construct() {
        $this->rating = new Rating();
        $url = isset($_GET['url']) ? $_GET['url'] : '';

        switch ($url) {

            case 'index' :
                $this->index();
                break;
            case 'vote' :
                $this->vote();
                break;
            case 'stats' :
                $this->stats();
                break;
            case 'ipTest' :
                $this->ipTest();
                break;
            default :
                $this->index();
        }
    }


    public function index() {

       	$this->messages();

        $this->rating->index();
    }

    public function vote() {
            if (isset($_GET['url'])) {
           
        }
        $this->rating->vote();
    }

    public function stats() {

        $this->rating->stats();
    }

    public function ipTest() {

        $this->rating->ipTest();
    }
	
	public function messages(){
		 if (isset($_GET['url'])) {
		 	
            if ($_GET['url'] == "saved")
                echo '<div id="message" class="no-error">Tänud hinde eest!
              <span id="closeMessage" title="Sulge">X</span></div>';
	 
	        if ($_GET['url'] == "error")
                echo '<div id="message" class="error">Valige hinne!
              <span id="closeMessage" title="Sulge">X</span></div>';
	 
        }
		
	}

}
