<?php

namespace Resources\Model;

use App\Connection;

class Container {
    public static function getModel($model) {
        $conn = Connection::getDatabase();
        $class = "\\App\\Models\\" . ucfirst($model);

        return new $class($conn);
    }
}
