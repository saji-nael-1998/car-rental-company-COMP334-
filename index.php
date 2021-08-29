<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
<title>Welcome</title>

    <link rel="stylesheet" href="css/style1.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <!-- set nav bar-->
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="car.php">Cars</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="logout.php">logout </a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="side_nav_section">
            <ul>
            <li><span>Menu</span></li>
                <?php
                function displayCustomerSideNav()
                {
                ?>
                   
                    <li><a href="customer_profile.php">Profile</a></li>
                    <li><a href="search.php">Rent Car</a></li>
                    <li><a href="my_rented_car.php">my rented car</a></li>
                <?php
                } ?>
                <?php
                function displayAdminSideNav()
                {
                ?>
                   
                    <li><a href="rented_car.php">Rented Car</a></li>
                    <li><a href="add_car.php">Add Car</a></li>
                <?php
                } ?>
                <?php
           
                if ($_SESSION['user'] != 'admin@store.ps') {
                    displayCustomerSideNav();
                } else {
                    displayAdminSideNav();
                } ?>
            </ul>

        </div>
    </main>
    <footer>
    </footer>
</body>

</html>