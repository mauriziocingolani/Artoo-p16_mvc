<?php

require './models/Utente.php';

class SiteController extends Controller {

    public $layout = 'main';
    public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
//        Application::GetIstanza()->db;
//        var_dump(Utente::FindByPk(1));
//        var_dump(Utente::FindAll('NomeUtente DESC'));
        var_dump(Utente::FindByCondition("NomeUtente='pippo' OR Abilitato=1"));
        # render
        $this->render('home', array('utenti' => $utenti, 'titolo' => 'Home page'));
    }

}
