<?php

class TabellaDatabase {

    protected static $nomeTabella;

    public static function FindByPk($pk) {
        $db = Application::GetIstanza()->db;
        $query = "SELECT * FROM " . static::$nomeTabella . ' WHERE ' . static::GetPk() . '=' . $pk;
        $result = $db->query($query);
        if ($result->num_rows == 1) :
            $obj = new static;
            $r = $result->fetch_object();
            foreach ($r as $prop => $value) :
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
