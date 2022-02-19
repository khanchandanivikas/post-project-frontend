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
    if(isset($_GET["category"])) {
        selectedCategory();
    }
?>
                </div>
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