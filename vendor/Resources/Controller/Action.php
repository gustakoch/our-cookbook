<?php

namespace Resources\Controller;

abstract class Action {
    protected $dados;

    public function __construct() {
        $this->dados = new \stdClass();
    }

    protected function render($view, $layout) {
        $this->dados->page = $view;

        if (file_exists("App/Views/".$layout.".php")) {
            require_once "App/Views/".$layout.".php";
        } else {
            $this->content();
        }
    }

    public function content() {
        $actualClass = get_class($this);
        $actualClass = str_replace('App\\Controllers\\', '', $actualClass);
        $actualClass = strtolower(str_replace('Controller', '', $actualClass));

        require_once "App/Views/".$actualClass."/".$this->dados->page.".php";
    }
}
