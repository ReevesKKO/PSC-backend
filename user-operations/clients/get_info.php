<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');

    $response = new stdClass();
    $response->code = 400;

    $db = new DB();
    $conn = $db->connect();

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $check_username = mysqli_query($conn, "SELECT * FROM accounts WHERE (username = '$username');");

        if(mysqli_num_rows($check_username)<=0) {
            $response->error_code = 1;
            $response->description = "Ошибка: пользователь с таким username не найден.";
        }
        else {
            $user_id = mysqli_fetch_assoc($check_username)['id'];
            $check_client = mysqli_query($conn, "SELECT * FROM clients WHERE (account_id = '$user_id');");

            if(mysqli_num_rows()<=0) {
              $response->error_code = 2;
              $response->description = "Ошибка: клиент с таким username не найден.";
            }
            else {
              $response->code = 200;
              $response->client_id = mysqli_fetch_assoc($check_client)['id'];
              $response->company_name = mysqli_fetch_assoc($check_client)['company_name'];
              $response->contact_person = mysqli_fetch_assoc($check_client)['contact_person'];
              $response->email = mysqli_fetch_assoc($check_client)['email'];
              $response->phone_num = mysqli_fetch_assoc($check_client)['phone_num'];
            }
        }
    } else {
        $response->error_code = 3;
        $response->description = "Ошибка: не все поля формы заполнены";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();
