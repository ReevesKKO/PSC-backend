<?php   
    function passwordHash($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    function verifyPassword($password, $hash) {
        $verify = password_verify($password, $hash);
        return $verify;
    }