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
        $company_name = $_POST['company_name'];
        $contact_person = $_POST['contact_person'];
        $email = $_POST['email'];
        $phone_num = $_POST['phone_num'];

        $check_username = mysqli_query($conn, "SELECT * FROM accounts WHERE (username = '$username');");

        if(mysqli_num_rows($check_username)>=1) {
            $response->error_code = 1;
            $response->description = "Ошибка: пользователь с таким username уже существует.";
        }
        else {
            $check_email_and_phone = mysqli_query($conn, "SELECT * FROM clients WHERE (email = '$email' OR phone_num = '$phone_num');");
            if (mysqli_num_rows($check_email_and_phone)>= 1) {
                $response->error_code = 2;
                $response->description = "Ошибка: пользователь с таким email или номером телефона уже существует.";
            }
            else {
                $password_hash = passwordHash($password);
                $insert = mysqli_query($conn, "INSERT INTO accounts(username, password) VALUES('$username', '$password_hash');");

                if (!$insert) {
                    $response->code = 500;
                    $response->error_code = 1;
                    $response->description = "Ошибка: не удалось добавить аккаунт пользователя.";
                }
                else {
                    $account_id = mysqli_insert_id($conn);

                    if (isset($account_id)) {
                        $insert_client = mysqli_query($conn,"INSERT INTO clients(company_name, contact_person, email, phone_num, account_id) VALUES('$company_name', '$contact_person', '$email', '$phone_num', '$account_id');");

                        if (!$insert_client) {
                            $response->error_code = 2;
                            $response->description = "Ошибка: не удалось добавить клиента.";
                        }
                        else {
                            $response->code = 200;
                            $response->description = "Успешная регистрация (клиент).";
                        }
                    }
                    else {
                      $response->code = 500;
                      $response->error_code = 3;
                      $response->description = "Ошибка: не удалось найти account_id для добавления клиента.";
                    }
                }
            }
        }
    } else {
        $response->error_code = 3;
        $response->description = "Ошибка: не все поля формы заполнены";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();
