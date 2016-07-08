<?php

class SiteController extends Controller {
   public $prop;

    public function actionHome() {
        $utenti = array('pippo', 'pluto', 'paperino');
        # render
        $this->render('home', array('utenti' => $utenti,'titolo'=>'Home page'));
    }

}
