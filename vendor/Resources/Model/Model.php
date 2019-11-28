<?php

namespace Resources\Model;

abstract class Model {
    protected $database;

    public function __construct(\PDO $database) {
        $this->database = $database;
    }
}
