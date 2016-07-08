<?php

class Controller {

    public $layout = '';
    public $_cartella;

    public function render($view, array $parametri = null) {
        # verificare che la view esista
        $file = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) .
                'views/' . $this->_cartella . '/' . $view . '.php';
        if (file_exists($file)) :
            if (isset($parametri)) :
                foreach ($parametri as $key => $value) :
                    ${$key} = $value;
                endforeach;
            endif;
            if (strlen($this->layout) > 0) :
                $layout = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) .
                        'views/layouts/' . $this->layout . '.php';
                if (file_exists($layout)) :
                    $contenutoPagina = $file;
                    require $layout;
                else :
                    die("Il layout '$layout' non esiste :-(");
                endif;
            else :
                require $file;
            endif;
        else :
            die("La view '$view' non esiste :-(");
        endif;
    }

}
