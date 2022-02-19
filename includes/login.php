<?php include 'functions.php'; ?>
<?php session_start(); ?>
<?php
if (isset($_POST["login"])) {
   $username = $_POST["username"];
   $password = $_POST["user_password"];

   $username = mysqli_real_escape_string($connection, $username);
   $password = mysqli_real_escape_string($connection, $password);

   $query = "SELECT * FROM users WHERE username = '{$username}' ";
   $result = mysqli_query($connection, $query);
   if (!$result) {
    die("query failed" . mysqli_error($connection));
};
while($row = mysqli_fetch_assoc($result)) {
    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
}
// $password = crypt($password, $db_user_password);
// if ($username === $db_username && $password === $db_user_password) {
if (password_verify($password, $db_user_password)) {
    $_SESSION["username"] = $db_username;
    $_SESSION["firstname"] = $db_user_firstname;
    $_SESSION["lastname"] = $db_user_lastname;
    $_SESSION["user_role"] = $db_user_role;
    header("Location: ../../backend/index.php");
} else {
    header("Location: ../index.php");
}
}
?>