<?php

class Utente extends TabellaDatabase {

    public static $nomeTabella = 'utenti';

    # sovrascrivo!

    public function beforeDelete() {
        parent::beforeDelete();
        var_dump('Sto per eliminare il record!');
    }

    # sovrascrivo!

    public function afterDelete() {
        parent::afterDelete();
        var_dump('Ho eliminato il record!');
    }

}
