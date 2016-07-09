<?php

class TabellaDatabase {

    protected static $nomeTabella;
    protected static $pk;
    protected static $fields;
    public $newRecord = true;
    private $_primaryKey;

    public function save() {
        if (!$this->newRecord) :
            $query = "UPDATE " . static::$nomeTabella . ' SET ';
            $fields = static::GetFields();
            $blocchi = array();
            foreach ($fields as $nomeCampo => $type) :
                if (is_integer(strpos($type, 'int('))) :
                    $valoreCampo = $this->$nomeCampo;
                elseif (is_integer(strpos($type, 'char(')) || is_integer(strpos($type, 'text'))) :
                    $valoreCampo = "'" . str_replace("'", "''", $this->$nomeCampo) . '\'';
                elseif (is_integer(strpos($type, 'datetime'))) :
                    $valoreCampo = "'" . str_replace("'", "''", $this->$nomeCampo) . '\'';
                    $a = "{$nomeCampo}TS";
                    $this->$a = strtotime($valoreCampo);
                else :
                    $valoreCampo = $this->$nomeCampo;
                endif;
                $s = $nomeCampo . ' = ' . $valoreCampo;
                $blocchi[] = $s;
            endforeach;
            $query = $query . join(', ', $blocchi) . " WHERE " . static::GetPk() . ' = ' . $this->_primaryKey;
            Application::GetIstanza()->db->query($query);
            return true;
        endif;
    }

    public function delete() {
        $this->beforeDelete();
        $query = "DELETE FROM " . static::$nomeTabella . " WHERE " . static::GetPk() . ' = ' . $this->_primaryKey;
        var_dump($query);
        $this->afterDelete();
    }

    public function beforeDelete() {
        var_dump('beforeDelete non fa niente!');
    }

    public function afterDelete() {
        var_dump('afterDelete non fa niente!');
    }

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
        $obj->newRecord = false;
        $fields = static::GetFields();
        $pk = static::GetPk();
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
            # "salvo" il valore della pk sulla variabile private _primaryKey
            if ($prop == $pk) :
                $obj->_primaryKey = $value;
            endif;
        endforeach;
        return $obj;
    }

}
