<?php

class TabellaDatabase {

    protected static $nomeTabella;

    public static function FindByPk($pk) {
        $db = Application::GetIstanza()->db;
        $query = "SELECT * FROM " . static::$nomeTabella . ' WHERE ' . static::GetPk() . '=' . $pk;
        var_dump($query);
    }

    protected static function GetPk() {
        $db = Application::GetIstanza()->db;
        $query = "SHOW COLUMNS FROM " . static::$nomeTabella;
        $result = $db->query($query);
        while (($r = $result->fetch_object()) != null) :
            if ($r->Key == 'PRI') :
                return $r->Field;
            endif;
        endwhile;
    }

}
