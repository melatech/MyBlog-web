<?php

include '../auth/db.php';

function signUp($user, $email, $password, $creation_Date){

    global $conn;
    $USER_NAME = mysqli_real_escape_string($conn, $user);
    $USER_EMAIL = mysqli_real_escape_string($conn, $email);
    $USER_PASSWORD = mysqli_real_escape_string($conn, $password);
    $PASSWORD = password_hash($USER_PASSWORD, PASSWORD_DEFAULT);
    $query = "INSERT INTO `users`(`name`, `email`, `password`, `creation_date`) VALUES ('$USER_NAME', '$USER_EMAIL', '$PASSWORD', '$creation_Date')";
    //$query .=
    $result = mysqli_query($conn, $query);
    if(!$result){
        //die("Query Failed" . mysqli_error($conn));
        return "Query Failed";
    }else{
        return $result;
    }
}

function login($email, $password){
    global $conn;
    $USER_EMAIL = mysqli_real_escape_string($conn, $email);
    $USER_PASSWORD = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE  email = '$USER_EMAIL'";
    $result = mysqli_query($conn, $query);

    if($result){
        $rowcount = mysqli_num_rows($result);
        if($rowcount == 1){
            $user = mysqli_fetch_array($result);
            $PASSWORD = $user['password'];

            if(password_verify($USER_PASSWORD, $PASSWORD)){
                return true;
            }else{
                return "Password does not match";
            }
        }

    }else{
        die("Query Failed" . mysqli_error($conn));
        //return "Query Failed";

    }

}

function isEmailExist($email){
    global $conn;

    $query = "SELECT email FROM users WHERE  email = '$email'" ;
    $result = mysqli_query($conn, $query);
    if($result){
        $rows = mysqli_num_rows($result);
        if($rows >= 1){
            return true;
        }else{
            return false;
        }
    }else{
        die("Query Failed" . mysqli_error($conn));
        //return "Query Failed";
    }

}
