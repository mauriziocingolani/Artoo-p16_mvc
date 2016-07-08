<?php

require './models/Utente.php';

class SiteController extends Controller {

    public $layout = 'main';
    public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
//        Application::GetIstanza()->db;
        var_dump(Utente::FindByPk(1));
        # render
        $this->render('home', array('utenti' => $utenti, 'titolo' => 'Home page'));
    }

}
