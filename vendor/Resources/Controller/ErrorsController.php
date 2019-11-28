<?php

namespace Resources\Controller;

use Resources\Controller\Action;

class ErrorsController extends Action {
    public function pageNotFound() {
        $this->render('404', 'Layout');
    }

    public function content() {
        $current = get_class($this);
        $class_name = str_replace("Resources\\Controller\\", "", $current);
        $class_name = strtolower(str_replace("Controller", "", $class_name));

        require_once "App/Views/" . $class_name . "/" . $this->dados->page . ".php";
    }
}

// COLOCAR A INFORMAÇÃO NO ELSE DO BOOTSTRAP, DEPOIS DO LOOP DAS ROTAS
/*
    $errors = new ErrorsController();
    $errors->pageNotFound();
*/