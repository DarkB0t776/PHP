<nav class="main-nav">
    <div class="main-nav__items">
        <div class="main-nav__logo">
            <a href="index.php" class="logo">Blogin</a>
            <span class="dot">.</span>
        </div>
        <!-- logo end -->
        <div class="main-nav__links">
            <a href="index.php" class="main-nav__link">Journal</a>
            <a href="#" class="main-nav__link">About</a>
            <a href="#" class="main-nav__link">Work</a>
            <a href="#" class="main-nav__link">Contact</a>
            <?php

            if (!isset($_SESSION['userLoggedIn'])) { ?>
                <a href="/signup.php" class="main-nav__link">Sign Up</a>
                <a href="/signin.php" class="main-nav__link">Sign In</a>
            <?php } else { ?>
                <a href="/admin/index.php" class="main-nav__link">Admin</a>
                <a href="/logout.php" class="main-nav__link">Log Out</a>
            <?php } ?>
        </div>
        <!-- /.main-nav__links -->
    </div>
</nav>