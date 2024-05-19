<?php

    $response = new stdClass();
    $response->code = 400;
    $tmp = [];

    $login_found = false;

    if(isset($_POST['login'])){
        $login = $_POST['login'];

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/PSC/user-operations/";
        $file = ($target_dir . "logs.log");

        $opfile = fopen($file, "r");
        if ($opfile) {
            $i = 0;
            while (!feof($opfile)) {
                $content = fgets($opfile);
                $pos = strpos($content, $login);
                if ($pos) {
                    $login_found = true;
                    $json_string = new stdClass;
                    $json_string->text = $content;
                    array_push($tmp, $json_string);
                }
                $i++;
            }
            if ($login_found) {
                $response->code = 200;
                $response->description = "Логи получены успешно";
                $response->logs = $tmp;
            }
            else {
                $response->error_code = 3;
                $response->description = "Ошибка: логи для указанного логина не найдены.";
            }
        }
        else {
            $response->error_code = 1;
            $response->description = "Ошибка: файл не найден.";
        }   
    } else {
      $response->error_code = 2;
      $response->description = "Ошибка: заполнены не все поля.";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
