<?php

require './models/Utente.php';

class SiteController extends Controller {

    public $layout = 'main';
    public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
        $utente = Utente::FindByPk(7);
        $utente->Modificato = date('Y-m-d H:m:i');
        $utente->Nome = 'Francesco';
        $utente->Cognome = 'Rossi';
        var_dump($utente->save());
        #
        # render
        $this->render('home', array('utenti' => $utenti, 'titolo' => 'Home page'));
    }

}
