<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/hash/hash.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/JWT/jwt.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/logger/logger.php');

    $response = new stdClass();
    $response->code = 400;

    $db = new DB();
    $conn = $db->connect();

    if(isset($_POST['login']) && isset($_POST['password'])){
        $login = $_POST['login'];
        $password = $_POST['password'];
        $check_user = mysqli_query($conn, "SELECT * FROM accounts WHERE (username = '$login');");
        $row = mysqli_fetch_assoc($check_user);
        if (mysqli_num_rows($check_user) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $role = $row['account_type'];
            $user_id = $row['id'];
            if ($dbusername == $login && verifyPassword($password, $dbpassword)) {
                $response->code = 200;
                $response->description = "Успешная авторизация.";
                $response->JWT = jwtEncodeHS256($user_id, $role);
                Logger::loginSuccessfully($login);
            }
            else {
              $response->error_code = 1;
              $response->description = "Ошибка: неверный пароль или логин.";
              Logger::loginErrorWarn($login);
            }
        }
        else {
          $response->error_code = 2;
          $response->description = "Ошибка: не найден пользователь с таким логином.";
        }
    } else {
      $response->error_code = 3;
      $response->description = "Ошибка: заполнены не все поля.";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();
