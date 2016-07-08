<?php

class TabellaDatabase {

    protected static $nomeTabella;
    protected static $pk;
    protected static $fields;

    public static function FindByPk($pk) {
        $db = Application::GetIstanza()->db;
        $query = "SELECT * FROM " . static::$nomeTabella . ' WHERE ' . static::GetPk() . '=' . $pk;
        $result = $db->query($query);
        if ($result->num_rows == 1) :
            $obj = new static;
            $r = $result->fetch_object();
            foreach ($r as $prop => $value) :
                # verificare tipologia del campo
                # cast a intero per i valori dei campi di categoria intera
                # assegnazione semplice per stringhe e per tutti gli altri
                $obj->$prop = $value;
            endforeach;
            return $obj;
        endif;
        return null;
    }

    public static function FindAll($order = null) {
        $db = Application::GetIstanza()->db;
        $query = "SELECT * FROM " . static::$nomeTabella;
        if ($order) :
            $query.=" ORDER BY " . $order;
        endif;
        $result = $db->query($query);
        if ($result->num_rows > 0) :
            $data = array();
            while (($r = $result->fetch_object()) != null) :
                $obj = new static;
                foreach ($r as $prop => $value) :
                    $obj->$prop = $value;
                endforeach;
                $data[] = $obj;
            endwhile;
            return $data;
        endif;
        return array();
    }

    public static function FindByCondition($condition, $order = null) {
        $db = Application::GetIstanza()->db;
        $query = "SELECT * FROM " . static::$nomeTabella .
                " WHERE " . $condition;
        if ($order) :
            $query.=" ORDER BY " . $order;
        endif;
        $result = $db->query($query);
        if ($result->num_rows > 0) :
            $data = array();
            while (($r = $result->fetch_object()) != null) :
                $obj = new static;
                foreach ($r as $prop => $value) :
                    $obj->$prop = $value;
                endforeach;
                $data[] = $obj;
            endwhile;
            return $data;
        endif;
        return array();
    }

    protected static function GetPk() {
        if (static::$pk == null) :
            static::_GetFields();
        endif;
        return static::$pk;
    }

    protected static function GetFields() {
        if (static::$fields == null) :
            static::_GetFields();
        endif;
        return static::$fields;
    }

    protected static function _GetFields() {
        if (static::$pk || is_array(static::$fields))
            return;
        $db = Application::GetIstanza()->db;
        $query = "SHOW COLUMNS FROM " . static::$nomeTabella;
        $result = $db->query($query);
        static::$fields = array();
        while (($r = $result->fetch_object()) != null) :
            if ($r->Key == 'PRI') :
                static::$pk = $r->Field;
            endif;
            static::$fields[$r->Field] = $r->Type;
        endwhile;
    }

}
