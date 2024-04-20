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

            if(mysqli_num_rows($check_client)<=0) {
              $response->error_code = 2;
              $response->description = "Ошибка: клиент с таким username не найден.";
            }
            else {
              while ($row = mysqli_fetch_assoc($check_client)) {
                  $tmp[] = $row;
              }
              $response->client_info = $tmp;
              $response->code = 200;
            }
        }
    } else {
        $response->error_code = 3;
        $response->description = "Ошибка: не все поля формы заполнены";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    $conn->close();
