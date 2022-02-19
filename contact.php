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
                                <h1>Contact</h1>
<?php 
if (isset($_POST["contact"])) {
    sendEmail();
}
?>
                                <form role="form" action="contact.php" method="post" 
                                    autocomplete="off">
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter User Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject" class="sr-only">Subject</label>
                                        <input type="text" name="subject" class="form-control"
                                            placeholder="Enter Your Subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="body" class="sr-only">Message</label>
                                        <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                                    </div>

                                    <input type="submit" name="contact" 
                                        class="btn btn-primary" value="Submit">
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