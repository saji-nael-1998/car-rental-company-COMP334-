<?php
session_start();
require_once('config.php');

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
                <?php
                function displayCustomerSideNav()
                {
                ?>
                    <li><span>Menu</span></li>
                    <li><a href="customer_profile.php">Profile</a></li>
                    <li><a href="search.php">Rent Car</a></li>
                    <li><a href="my_rented_car.php">my rented car</a></li>
                <?php
                } ?>
                <?php
                function displayAdminSideNav()
                {
                ?>
                    <li><span>Menu</span></li>
                    <li><a href="rented_car.php">Rented Car</a></li>
                    <li><a href="add_car.php">Add Car</a></li>
                <?php

                } ?>
                <?php

                if ($_COOKIE['user'] != 'admin@store.ps') {
                    displayCustomerSideNav();
                } else {
                    displayAdminSideNav();
                }
                ?>
            </ul>

        </div>
        <div class="main_container">
            <div class="main_item">
                <div id="table_container">

                    <table class="data_table">
                        <caption>Rented Car</caption>
                        <thead>
                            <th>Customer Name</th>
                            <th>Car Reference Number</th>
                            <th>Start Rental Date & Time</th>
                            <th>End Rental Date & Time</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
                            $sql = "SELECT * from car c,rental r, customer u WHERE r.customerID=u.customerID and r.carID=c.carID and u.customerID=".$_SESSION['customerID'];
                            $statement = $conn->prepare($sql);
                            $statement->execute();
                            $result = $statement->fetchAll();
                            $conn = null;
                            for ($counter = 0; $counter < sizeof($result); $counter++) {
                            ?>
                                <tr>
                                    <td><?php echo $result[$counter]['FName'] . ' ' . $result[$counter]['LName']; ?></td>
                                    <td><?php echo $result[$counter]['carReferenceNumber']; ?></td>
                                    <td><?php echo $result[$counter]['rentalStartdate']; ?></td>
                                    <td><?php echo $result[$counter]['rentalEnddate']; ?></td>
                                </tr>
                            <?php

                            }
                            ?>



                        </tbody>
                    </table>




                </div>

            </div>

        </div>

    </main>

</body>

</html>