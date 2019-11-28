<?php
 
namespace Resources\Model;

use App\ConnectionDatabase;

class Container {
    public static function getModel($model) {

        $conn = ConnectionDatabase::getDatabase();
        $class = "\\App\\Models\\" . ucfirst($model);

        return new $class($conn);
    }
}
