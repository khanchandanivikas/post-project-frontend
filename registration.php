<?php include './includes/head.php'?>

<body>
    <!-- Responsive navbar-->
    <?php include './includes/navbar.php'?>

    <!-- Page header with logo and tagline-->
    <?php include './includes/header.php'?>

    <!-- Page content-->
    <div class="container">
        <div class="row">
            <section id="login">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="form-wrap">
                                <h1>Register</h1>
                                <?php 
// if (isset($_POST["register"])) {
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    global $connection;
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    
    // $hashFormat = "$2y$10$";
    // $salt = "clavesupermegasecretooo";
    // $hashF_and_salt = $hashFormat.$salt;
    // $password = crypt($password, $hashF_and_salt);
    
    $error = [
        'username'=>'',
        'email'=>'',
        'password'=>''
    ];

    if (strlen($username) < 4) {
        $error['username'] = 'Username Needs To Be Longer';
    }
    if ($username === "") {
        $error['username'] = 'Username Cannot Be Empty';
    }
    if (usernameExists ($username)) {
        $error['username'] = 'Username Already Exists';
    }
    if ($email === "") {
        $error['email'] = 'Email Cannot Be Empty';
    }
    if (emailExists ($email)) {
        $error['email'] = 'Email Already Exists, <a href="index.php">Login</a>';
    }
    if ($password === "") {
        $error['password'] = 'Password Cannot Be Empty';
    } 
    foreach($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        };
    }    
    if (empty($error)) {
        $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));
        $query_register = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query_register .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber') ";
        $result_register = mysqli_query($connection, $query_register);
        if (!$result_register) {
            die("insertion failed" . mysqli_error($connection));
        } 
        echo "<p class='bg-success'>Registration Complete</p>";
    }
}
?>
                                <form role="form" action="registration.php" method="post" id="login-form"
                                    autocomplete="off">
                                    <div class="form-group">
                                        <label for="username" class="sr-only">username</label>
                                        <input type="text" name="username" class="form-control"
                                            placeholder="Enter Desired Username" autocomplete="on"
                                            value="<?php echo isset($username) ? $username : '' ?>">
                                        <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="somebody@example.com" autocomplete="on"
                                            value="<?php echo isset($email) ? $email : '' ?>">
                                        <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="sr-only">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Password">
                                        <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                    </div>

                                    <input type="submit" name="register" id="btn-login" class="btn btn-primary"
                                        value="Register">
                                </form>

                            </div>
                        </div> <!-- /.col-xs-12 -->
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </section>
        </div>
    </div>
    <!-- Footer-->
    <?php include './includes/footer.php'?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>