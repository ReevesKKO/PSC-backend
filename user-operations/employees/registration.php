<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/hash/hash.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/JWT/jwt.php');

    $response = new stdClass();
    $response->code = 400;

    $db = new DB();
    $conn = $db->connect();

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $full_name = $_POST['full_name'];
        $position = $_POST['position'];
        $salary = $_POST['salary'];
        $hire_date = $_POST['hire_date'];
        $email = $_POST['email'];

        $check_username = mysqli_query($conn, "SELECT * FROM accounts WHERE (username = '$username');");

        if(mysqli_num_rows($check_username)>=1) {
            $response->error_code = 1;
            $response->description = "Ошибка: пользователь с таким username уже существует.";
        }
        else {
            $password_hash = passwordHash($password);
            $insert = mysqli_query($conn, "INSERT INTO accounts(username, password, account_type) VALUES('$username', '$password_hash', 'employee');");
            if (!$insert) {
                $response->error_code = 2;
                $response->description = "Ошибка: не удалось добавить аккаунт пользователя.";
            }
            else {
                $account_id = mysqli_insert_id($conn);
                if (isset($account_id)) {
                    $insert_client = mysqli_query($conn,"INSERT INTO employees(full_name, position, salary, hire_date, email) VALUES('$full_name', '$position', '$salary', '$hire_date', '$email');");
                    if (!$insert_client) {
                        $response->error_code = 3;
                        $response->description = "Ошибка: не удалось добавить сотрудника.";
                    }
                    else {
                        $response->code = 200;
                        $response->description = "Успешная регистрация (сотрудник).";
                    }
                }
                else {
                    $response->code = 500;
                    $response->error_code = 1;
                    $response->description = "Ошибка: не удалось найти account_id для добавления сотрудника.";
                }
            }
        }
    } else {
        $response->error_code = 5;
        $response->description = "Ошибка: не все поля формы заполнены";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();
