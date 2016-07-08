<?php

class Controller {

    public $_cartella;

    public function render($view, array $parametri = null) {
        # verificare che la view esista
        $file = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) .
                'views/' . $this->_cartella . '/' . $view . '.php';
        if (file_exists($file)) :
            
        else :
            die("La view '$view' non esiste :-(");
        endif;
    }
    
}
