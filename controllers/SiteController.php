<?php

require './models/Utente.php';

class SiteController extends Controller {

    public $layout = 'main';
    public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
//        Application::GetIstanza()->db;
        $utente = Utente::FindByPk(1);
        var_dump(date('d/m/Y', $utente->CreatoTS));
//        var_dump(Utente::FindAll('NomeUtente DESC'));
//        var_dump(Utente::FindByCondition("NomeUtente='pippo' OR Abilitato=1"));
        # render
        $this->render('home', array('utenti' => $utenti, 'titolo' => 'Home page'));
    }

}
