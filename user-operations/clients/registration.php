<?php
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/hash/hash.php');
    include($_SERVER['DOCUMENT_ROOT'].'/PSC/db_connect.php');

    $db = new DB();
    $conn = $db->connect();

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $company_name = $_POST['company_name'];
        $contact_person = $_POST['contact_person'];
        $email = $_POST['email'];
        $phone_num = $_POST['phone_num'];

        // TODO: проверка на username и на email + phone_num

        $password_hash = passwordHash($password);
        $insert = mysqli_query($conn, "INSERT INTO accounts(username, password) VALUES('$username;, $password_hash');");
        // TODO: проверка $insert + $response
        $search_id = mysqli_query($conn, "SELECT * FROM accounts WHERE(username='$username');");
        $account_id = $search_id->$id;

        if (isset($account_id)) {
            $insert_client = mysqli_query($conn,"INSERT INTO clients(company_name, contact_person, email, phone_num, account_id) VALUES('$company_name', '$contact_person', '$email', '$phone_num', '$account_id');");
            // TODO: тут проверку сделай ёптэ и response Success or Error
        }
        else {
            $response = "Error";
        }


    } else {
        $response = "Ошибка: не все поля формы заполнены";
    }
    
    echo $response;
    $conn->close();