<?php

final class Application {
    # singleton: una e una sola istanza

    private static $_istanza;

    private function __construct() {
        
    }
    
    /* ..../controller/azione */
    public function run() {
        
    }

    public static function GetIstanza() {
        if (self::$_istanza == null)
            self::$_istanza = new self;
        return self::$_istanza;
    }

}
