<div class="col-lg-4">
    <!-- Search widget-->
    <div class="card mb-4">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form action="search.php" method="post">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Enter search term..." name="search" />
                    <button class="btn btn-primary" type="submit">Go!</button>
                </div>
            </form>
        </div>
    </div>
    <!-- login form -->
    <div class="card mb-4">
        <?php 
         if (isset($_SESSION["user_role"])) {
            echo "<h4>Logged In As "; 
            echo $_SESSION["username"];
            echo "</h4>";
            echo "<a href='./includes/logout.php' class='btn btn-primary'>Logout</a>";
        } else {
            echo "
        <div class='card-header'>Login</div>
        <div class='card-body'>
            <form action='includes/login.php' method='post'>
                <div class='input-group'>
                    <input class='form-control' type='text' placeholder='username' name='username' />
                </div>
                <div class='input-group'>
                    <input class='form-control' type='password' placeholder='password' name='user_password' />
                    <button class='btn btn-primary' type='submit' name='login'>Submit</button>
                </div>
            </form>
        </div>";
        }
        ?>
    </div>
    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Categories</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="list-unstyled mb-0">
                        <?php showAllCategories(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>