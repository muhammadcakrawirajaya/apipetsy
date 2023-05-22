<?php
$user_name = $_POST["user_name"];
$user_password = $_POST["password"];

require 'init.php';

if ($con) {
    // Hash the user-provided password
    // password hashing
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    $sql = "SELECT name, password FROM user_info WHERE user_name='$user_name'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        // Verify the hashed password
        if (password_verify($user_password, $stored_password)) {
            $status = "ok";
            $result_code = 1;
            $name = $row['name'];
            echo json_encode(array('status' => $status, 'result_code' => $result_code, 'name' => $name));
        } else {
            $status = "ok";
            $result_code = 0;
            echo json_encode(array('status' => $status, 'result_code' => $result_code));
        }
    } else {
        $status = "ok";
        $result_code = 0;
        echo json_encode(array('status' => $status, 'result_code' => $result_code));
    }
} else {
    $status = "failed";
    echo json_encode(array('status' => $status), JSON_FORCE_OBJECT);
}

mysqli_close($con);
?>