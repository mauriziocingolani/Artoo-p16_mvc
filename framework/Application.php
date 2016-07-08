<?php

final class Application {
    # singleton: una e una sola istanza

    private static $_istanza;
    private $_config;
    public $db;

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
                    $c = new $controller;
                    $c->_cartella = $ca['controller'];
                    $c->$metodo();
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

    public static function GetIstanza(array $config = null) {
        if (self::$_istanza == null)
            self::$_istanza = new self;
        if (self::$_istanza->_config == null) :
            self::$_istanza->_config = $config;
            # connessione daatabase
            if (isset($config['db'])) :
                self::$_istanza->db = new mysqli(
                        $config['db']['host']
                        , $config['db']['user']
                        , $config['db']['password']
                        , $config['db']['database']
                );
                if (self::$_istanza->db->connect_errno > 0) :
                    throw new Exception(self::$_istanza->db->connect_error, self::$_istanza->db->connect_errno);
                endif;
            endif;
        endif;
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
