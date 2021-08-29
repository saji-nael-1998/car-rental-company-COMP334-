<?php
session_start();
require_once('config.php');







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
                <?php
                if (isset($_SESSION['user'])) { ?>
                    <li><a href="logout.php">logout </a></li>
                <?php

                } else { ?>
                    <li><a href="form_1.php">Register</a></li>
                    <li><a href="login.php">Login </a></li>
                <?php } ?>

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
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user'] != 'admin@store.ps') {
                        displayCustomerSideNav();
                    } else {
                        displayAdminSideNav();
                    }
                }

                ?>
            </ul>

        </div>
        <div class="main_container">
            <div class="main_item">
                <div id="table_container">

                    <table class="data_table">
                        <caption> Car</caption>
                        <thead>
                            <th>Car reference number</th>
                            <th>model</th>
                            <th>year</th>
                            <th> price per day</th>
                            <th>description </th>
                            <th>option</th>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * from car c ";
                            $statement = $conn->prepare($sql);
                            $statement->execute();
                            $result = $statement->fetchAll();
                            $conn = null;
                            for ($counter = 0; $counter < sizeof($result); $counter++) {
                            ?>
                                <tr>

                                    <td> <?php echo $result[$counter]['carReferenceNumber']; ?></td>
                                    <td> <?php echo $result[$counter]['modelName']; ?></td>
                                    <td> <?php echo $result[$counter]['year']; ?></td>
                                    <td> <?php echo $result[$counter]['pricePerDay']; ?></td>
                                    <td> <?php echo $result[$counter]['description']; ?></td>
                                    <td>
                                        <div>


                                            <a href="car_view.php?carReferenceNumber=<?php echo $result[$counter]['carReferenceNumber']; ?>">View</a>

                                            <?php
                                            if (isset($_SESSION['user'])) {
                                                if ($_SESSION['user'] != 'admin@store.ps') { ?>
                                                    <a href="rent_car.php?carReferenceNumber=<?php echo $result[$counter]['carReferenceNumber'] . "&carID=" . $result[$counter]['carID'] . "&pricePerDay=" . $result[$counter]['pricePerDay']; ?>">rent</a>

                                                <?php

                                                }
                                            } else { ?>
                                                <a href="rent_car.php?carReferenceNumber=<?php echo $result[$counter]['carReferenceNumber'] . "&carID=" . $result[$counter]['carID'] . "&pricePerDay=" . $result[$counter]['pricePerDay']; ?>">rent</a>

                                            <?php } ?>




                                        </div>
                                    </td>

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