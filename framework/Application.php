<?php

final class Application {
    # singleton: una e una sola istanza

    private static $_istanza;

    private function __construct() {
        
    }

    /* ..../controller/azione */

    public function run() {
        if (count($_GET) > 0) :
            $ca = $this->_elaboraRichiesta($_GET['route']);
        else :
            $script = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
            $controllerAction = str_replace($script, '', $_SERVER['REQUEST_URI']);
            $ca = $this->_elaboraRichiesta($controllerAction);
        endif;
        $cartella = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $controller = $this->_primaLetteraMaiuscola($ca['controller']) . 'Controller';
        if (file_exists($cartella . 'controllers/' . $controller . '.php')) :
            require_once 'controllers/' . $controller . '.php';
            if (class_exists($controller)) :
                $metodo = 'action' . $this->_primaLetteraMaiuscola($ca['action']);
                if (method_exists($controller, $metodo)) :
                else :
                    die('Azione ' . $metodo . ' non presente nel controller ' . $controller . ' :-(');
                endif;
            else :
                die('Classe ' . $controller . ' non presente nel file /controllers/' . $controller . '.php :-(');
            endif;
        else :
            die('File ' . $controller . '.php non presente nella cartella /controllers :-(');
        endif;
    }

    public static function GetIstanza() {
        if (self::$_istanza == null)
            self::$_istanza = new self;
        return self::$_istanza;
    }

    /* controller/action */

    private function _elaboraRichiesta($controllerAction) {
        $a = split('/', $controllerAction);
        /* list() */
        return array(
            'controller' => $a[0],
            'action' => $a[1],
        );
    }

    private function _primaLetteraMaiuscola($stringa) {
        return strtoupper($stringa[0]) . substr($stringa, 1);
    }

    private function _server() {
        foreach ($_SERVER as $k => $v) :
            echo "$k => $v<br />";
        endforeach;
    }

}
