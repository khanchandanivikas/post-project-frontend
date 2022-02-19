<?php include './includes/head.php'?>

<body>
    <!-- Responsive navbar-->
    <?php include './includes/navbar.php'?>

    <!-- Page header with logo and tagline-->
    <?php include './includes/header.php'?>

    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Featured blog post-->
                <div class="card mb-4">
                    <?php 
                       global $connection;
                       if (isset($_GET['page'])) {
                           $page = $_GET['page'];
                       } else {
                           $page = "";
                       }
                       if ($page === "" || $page === 1) {
                           $page_1 = 0;
                       } else {
                           $page_1 = $page*2 - 2;
                       }
                       if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
                        $query = "SELECT * FROM post LIMIT $page_1, 2 ";
                       } else {
                        $query = "SELECT * FROM post WHERE post_status = 'published' LIMIT $page_1, 2 ";
                       }
                       $result = mysqli_query($connection, $query);
                       if (!$result) {
                           die("query failed" . mysqli_error($connection));
                       } 
                       if (mysqli_num_rows($result) < 1) {
                        echo "<h1 class='text-center'>No Posts Available</h1>";
                    }
                       while($row = mysqli_fetch_assoc($result)) {
                           $post_id = $row['post_id'];
                           $post_category_id = $row['post_category_id'];
                           $post_title = $row['post_title'];
                           $post_author = $row['post_author'];
                           $post_date = $row['post_date'];
                           $post_img = $row['post_img'];
                           $post_content = substr($row['post_content'],0,400);
                           $post_tags = $row['post_tags'];
                           $post_comment_count = $row['post_comment_count'];
                           $post_status = $row['post_status'];
                   
                           echo "<img class='card-img-top' src='../images/{$post_img}' alt='blog image' />
                               <div class='card-body'>
                                   <div class='small text-muted'>{$post_date}</div>
                                   <div class='small text-muted'>{$post_author}</div>
                                   <h2 class='card-title h4'>{$post_title}</h2>
                                   <p class='card-text'>{$post_content}</p>
                                   <a href='post.php?p_id=$post_id' class='btn btn-primary' href='#!'>Read more →</a>
                               </div>
                           ";
                       }
                    ?>
                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <?php 
            global $connection;
            $query_count = "SELECT * FROM post ";
            $result_count = mysqli_query($connection, $query_count);
            if (!$result_count) {
                die("query failed" . mysqli_error($connection));
            } 
            $count = mysqli_num_rows($result_count);
            $count = ceil($count / 2);
            for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
            echo "<li class='page-item active'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
            echo "<li><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
        ?>
                    </ul>
                </nav>
            </div>
            <!-- Side widgets-->
            <?php include './includes/sidebar.php'?>
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