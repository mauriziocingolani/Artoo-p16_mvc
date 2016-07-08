<?php

class SiteController extends Controller {

    public $layout = 'main';
    public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
        # render
        $this->render('home', array('utenti' => $utenti, 'titolo' => 'Home page'));
    }

}
