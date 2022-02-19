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
    if(isset($_GET["p_id"])) {
        selectedPost();
    }
?>
                </div>
                <!-- comment section -->
                <section class="mb-5">
                    <div class="card bg-light">
                        <div class="card-body">
                            <!-- Comment form-->
                            <form class="mb-4" action="" method="post">
                                <div class="form-group">
                                    <label for="comment_author">Author</label>
                                    <input type="text" class="form-control" name="comment_author">
                                </div>
                                <div class="form-group">
                                    <label for="comment_email">Email</label>
                                    <input type="email" class="form-control" name="comment_email">
                                </div>
                                <div class="form-group">
                                    <label for="comment_content">Comment</label>
                                    <textarea class="form-control" rows="3" name="comment_content"
                                        placeholder="Join the discussion and leave a comment!"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="create_comment">
                                    Submit
                                </button>
                            </form>
                            <?php
if (isset($_POST["create_comment"])) {
    createComment();
}
?>
                            <!-- Comment with nested comments-->
                            <div class="d-flex mb-4">
                                <!-- Parent comment-->
                                <div class="flex-shrink-0">
                                    <?php showPostComments(); ?>
                                    <!-- Child comment 1-->
                                    <!-- <div class="d-flex mt-4">
                                        <div class="flex-shrink-0"><img class="rounded-circle"
                                                src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                        <div class="ms-3">
                                            <div class="fw-bold">Commenter Name</div>
                                            And under those conditions, you cannot establish a capital-market evaluation
                                            of that enterprise. You can't get investors.
                                        </div>
                                    </div> -->
                                    <!-- Child comment 2-->
                                    <!-- <div class="d-flex mt-4">
                                        <div class="flex-shrink-0"><img class="rounded-circle"
                                                src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                        <div class="ms-3">
                                            <div class="fw-bold">Commenter Name</div>
                                            When you put money directly to a problem, it makes a good headline.
                                        </div>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- comment section ends -->
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