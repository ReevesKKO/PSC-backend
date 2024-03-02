<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/hash/hash.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');

    $db = new DB();
    $conn = $db->connect();

    // TODO: ПЕРЕДЕЛАТЬ ПОД EMPLOYEE

    /*if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $company_name = $_POST['company_name'];
        $contact_person = $_POST['contact_person'];
        $email = $_POST['email'];
        $phone_num = $_POST['phone_num'];

        $check_username = mysqli_query($conn, "SELECT * FROM accounts WHERE (username = '$username');");
        
        if(mysqli_num_rows($check_username)>=1) {
            $response = "Ошибка: пользователь с таким username уже существует.";
        }
        else {
            $check_email_and_phone = mysqli_query($conn, "SELECT * FROM clients WHERE (email = '$email' OR phone_num = '$phone_num');");
            if (mysqli_num_rows($check_email_and_phone)>= 1) {
                $response = "Ошибка: пользователь с таким email или номером телефона уже существует.";
            }
            else {
                $password_hash = passwordHash($password);
                $insert = mysqli_query($conn, "INSERT INTO accounts(username, password) VALUES('$username', '$password_hash');");

                if (!$insert) {
                    $response = "Ошибка: не удалось добавить аккаунт пользователя.";
                }
                else {  
                    $account_id = mysqli_insert_id($conn);

                    if (isset($account_id)) {
                        $insert_client = mysqli_query($conn,"INSERT INTO clients(company_name, contact_person, email, phone_num, account_id) VALUES('$company_name', '$contact_person', '$email', '$phone_num', '$account_id');");
                        
                        if (!$insert_client) {
                            $response = "Ошибка: не удалось добавить клиента.";
                        }
                        else {
                            $response = "Успешно добавлен пользователь (клиент).";
                        }
                    }
                    else {
                        $response = "Ошибка: не удалось найти account_id для добавления клиента.";
                    }
                } 
            }
        }
    } else {
        $response = "Ошибка: не все поля формы заполнены";
    }*/
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();