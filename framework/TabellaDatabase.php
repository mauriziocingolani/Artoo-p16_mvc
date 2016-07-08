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
            $r = $result->fetch_object();
            return static::_GetRecordObject($r);
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
                $data[] = static::_GetRecordObject($r);
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
                $data[] = static::_GetRecordObject($r);
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

    private static function _GetRecordObject($r) {
        $obj = new static;
        $fields = static::GetFields();
        foreach ($r as $prop => $value) : 
            $type = $fields[$prop];
            if (is_integer(strpos($type, 'int('))) :
                $obj->$prop = (int) $value;
            elseif (is_integer(strpos($type, 'char(')) || is_integer(strpos($type, 'text'))) :
                $obj->$prop = $value;
            elseif (is_integer(strpos($type, 'datetime'))) :
                $obj->$prop = $value;
                $a = "{$prop}TS";
                $obj->$a = strtotime($value);
            else :
                $obj->$prop = $value;
            endif;
        endforeach;
        return $obj;
    }

}
