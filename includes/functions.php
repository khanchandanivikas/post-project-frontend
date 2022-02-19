<?php 
//Get Heroku ClearDB connection information
// $cleardb_url = parse_url(getenv("mysql://becbd31583a24e:19181a40@eu-cdbr-west-02.cleardb.net/heroku_c834d7e4d6c8ae1?reconnect=true"));
// $cleardb_server = $cleardb_url["eu-cdbr-west-02.cleardb.net"];
// $cleardb_username = $cleardb_url["becbd31583a24e"];
// $cleardb_password = $cleardb_url["19181a40"];
// $cleardb_db = substr($cleardb_url["blog"],1);
// $active_group = 'default';
// $query_builder = TRUE;
// $connection = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

$connection = mysqli_connect("eu-cdbr-west-02.cleardb.net", "bd8409b2b9cdab", "a0495e69", "heroku_e635513b8596262");

if (!$connection) {
    die("connection failed");
} 

function showAllCategories () {
    global $connection;
    $query = "SELECT * FROM categories ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    while($row = mysqli_fetch_assoc($result)) {
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];

        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</li>";
    }
};

function searchPost () {
    global $connection;
    $search = $_POST['search'];
    if ($search == 0 || empty($search)) {
    echo "<h2>field cannot be empty</h2>";
    } else {
    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
        $query = "SELECT * FROM post WHERE post_tags LIKE '%$search%' ";
       } else {
        $query = "SELECT * FROM post WHERE post_tags LIKE '%$search%' AND post_status = 'published' ";
       }
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    $count = mysqli_num_rows($result);
    if (!$count) {
        echo "<h1> No Result </h1>";
    } else  {
    while($row = mysqli_fetch_assoc($result)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_img = $row['post_img'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        echo "<img class='card-img-top' src='../images/{$post_img}' alt='blog image' />
            <div class='card-body'>
                <div class='small text-muted'>{$post_date}</div>
                <div class='small text-muted'>{$post_author}</div>
                <h2 class='card-title h4'>{$post_title}</h2>
                <p class='card-text'>{$post_content}</p>
                <a class='btn btn-primary' href='#!'>Read more →</a>
            </div>
        ";
    }
  }
 }
};

function selectedCategory () {
    $the_post_cat_id = $_GET["category"];
    global $connection;
    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
        $query = "SELECT * FROM post WHERE post_category_id = $the_post_cat_id ";
       } else {
        $query = "SELECT * FROM post WHERE post_category_id = $the_post_cat_id AND post_status = 'published' ";
       }
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    if (mysqli_num_rows($result) < 1) {
        echo "<h1 class='text-center'>No Posts Available</h1>";
    } else {
        while($row = mysqli_fetch_assoc($result)) {
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_img = $row['post_img'];
            $post_content = $row['post_content'];
            echo "<img class='card-img-top' src='../images/{$post_img}' alt='blog image' />
            <div class='card-body'>
                <div class='small text-muted'>{$post_date}</div>
                <div class='small text-muted'>{$post_author}</div>
                <h2 class='card-title h4'>{$post_title}</h2>
                <p class='card-text'>{$post_content}</p>
                <a class='btn btn-primary' href='#!'>Read more →</a>
            </div>
        ";
        }
    }
}

function selectedPost () {
    global $connection;
    $the_post_id = $_GET["p_id"];
    $query_count_update = "UPDATE post SET post_views =  post_views + 1 WHERE post_id = $the_post_id ";
    $result_count_update = mysqli_query($connection, $query_count_update);
    if (!$result_count_update) {
        die("query failed" . mysqli_error($connection));
    } 
    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
        $query = "SELECT * FROM post WHERE post_id = $the_post_id ";
       } else {
        $query = "SELECT * FROM post WHERE post_id = $the_post_id AND post_status = 'published' ";
       }
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    if (mysqli_num_rows($result) < 1) {
        echo "<h1 class='text-center'>No Posts Available</h1>";
    }
    while($row = mysqli_fetch_assoc($result)) {
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_img = $row['post_img'];
        $post_content = $row['post_content'];
        echo "<img class='card-img-top' src='../images/{$post_img}' alt='blog image' />
        <div class='card-body'>
            <div class='small text-muted'>{$post_date}</div>
            <div class='small text-muted'>{$post_author}</div>
            <h2 class='card-title h4'>{$post_title}</h2>
            <p class='card-text'>{$post_content}</p>
        </div>
    ";
}
}

function createComment () {
    global $connection;
    $the_post_id = $_GET["p_id"];
    $comment_author = $_POST['comment_author'];
    $comment_email = $_POST['comment_email'];
    $comment_content = $_POST['comment_content'];
    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
    $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now()) ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("insertion failed" . mysqli_error($connection));
    } 
    $query = "UPDATE post SET post_comment_count = post_comment_count + 1 ";
    $query .= "WHERE post_id = $the_post_id ";
    $result = mysqli_query($connection, $query);
};

function showPostComments () {
    global $connection;
    $the_post_id = $_GET["p_id"];
    $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
    $query .= "AND comment_status = 'approved' ";
    $query .= "ORDER BY comment_id DESC ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    while($row = mysqli_fetch_assoc($result)) {
        $comment_author = $row['comment_author'];
        $comment_date = $row['comment_date'];
        $comment_content = $row['comment_content'];
        echo "<div class='flex-shrink-0'>
                <img class='rounded-circle' src='https://dummyimage.com/50x50/ced4da/6c757d.jpg'alt='...' />
              </div>
            <div class='ms-3'> 
                <div class='fw-bold'>$comment_author <h4>$comment_date</h4>
                </div>
                $comment_content
            </div>";
    }
}

function redirect($location) {
    return header('Location:' . $location);
}

function usernameExists ($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    };
}

function emailExists ($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    };
}

function registerUser () {
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

function sendEmail () {
    $to = "khanchandani58@gmail.com";
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    $header = "From: " .$_POST['email'];

    mail($to, $subject, $body, $header);
    echo "<p class='bg-success'>Message Sent</p>";
}

?>