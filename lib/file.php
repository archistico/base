<?php

// __FILE__

class File {
    public static function FILENAME($file) {
        // Example: test
        $path_parts = pathinfo($file);
        return $path_parts['filename'];
    }

    public static function DIRNAME($file) {
        // Example: /var/www/html
        $path_parts = pathinfo($file);
        return $path_parts['dirname'];
    }

    public static function BASENAME($file) {
        // Example: test.php
        $path_parts = pathinfo($file);
        return $path_parts['basename'];
    }

    public static function EXTENSION($file) {
        // Example: php
        $path_parts = pathinfo($file);
        return $path_parts['extension'];
    }

    public static function FILE_EXIST($nomefile, $tipo) {
        // Parametri
        require('config.php');

        if (file_exists(GLOBAL_FILE_UPLOAD."/".strtolower($tipo)."/".$nomefile.".".strtolower($tipo))) {
            return true;
        } else {
            return false;
        }
    }

    public static function FILE_DELETE($nomefile, $tipo) {
        // Parametri
        require('config.php');

        if(self::FILE_EXIST($nomefile, $tipo)) {
            if(unlink(GLOBAL_FILE_UPLOAD."/".strtolower($tipo)."/".$nomefile.".".strtolower($tipo))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}