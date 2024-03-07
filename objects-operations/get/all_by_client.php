<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');

    $response = new stdClass();
    $response->code = 500;

    $db = new DB();
    $conn = $db->connect();

    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        $select_client_id_query = mysqli_query($conn, "SELECT * FROM clients WHERE (account_id = '$user_id');");
        if(mysqli_num_rows($select_client_id_query) == 0) {
            $response->error_code = 1;
            $response->description = "Ошибка: клиента с таким account_id не удалось найти.";
        }
        else {
            $client_id = mysqli_fetch_assoc($select_client_id_query)['id'];
            if ($client_id == "") {
                $response->error_code = 2;
                $response->description = "Ошибка: клиента с таким id не удалось найти.";
            }
            else {
                $all_objects_of_user_query = mysqli_query($conn, "SELECT * FROM security_objects WHERE (client_id = '$client_id');");
                while ($row = mysqli_fetch_assoc($all_objects_of_user_query)) {
                    $tmp[] = $row;
                }
                $response->code = 200;
                $response->description = "Успешно получены все объекты пользователя.";
                $response->objects = $tmp;
            }
        }
    }
    else {
        $response->error_code = 3;
        $response->description = "Ошибка: не все поля заполнены.";
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    mysqli_close($conn);