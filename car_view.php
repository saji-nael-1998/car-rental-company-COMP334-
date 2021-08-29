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
            <ul> <li><span>Menu</span></li>
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
                } ?>
            </ul>

        </div>
        <div class="main_container">
            <div class="main_item">
                <table id="car_info">
                    <caption>
                        car
                    </caption>
                    <?php
                    //fetch data 
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = " SELECT * FROM car WHERE carReferenceNumber= '" . $_GET['carReferenceNumber'] . "'";

                    $statement = $conn->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetchAll();


                    ?>

                    <thead>

                        <th>carReferenceNumber</th>
                        <th>modelName</th>
                        <th>year</th>
                        <th>pricePerDay</th>
                        <th>manufacturingCountry</th>
                        <th>capacity</th>
                        <th>color</th>
                        <th>totalPrice</th>
                        <th>avgOfPetroleum</th>
                        <th>hoursePower</th>
                        <th>lenght</th>
                        <th>width</th>
                        <th>description</th>

                    </thead>
                    <tbody>
                        <tr>

                            <td><?php echo $result[0]['carReferenceNumber']; ?></td>
                            <td><?php echo $result[0]['modelName']; ?></td>
                            <td><?php echo $result[0]['year']; ?></td>
                            <td><?php echo $result[0]['pricePerDay']; ?></td>
                            <td><?php echo $result[0]['manufacturingCountry']; ?></td>
                            <td><?php echo $result[0]['capacity']; ?></td>
                            <td><?php echo $result[0]['color']; ?></td>
                            <td><?php echo $result[0]['totalPrice']; ?></td>
                            <td><?php echo $result[0]['avgOfPetroleum']; ?></td>
                            <td><?php echo $result[0]['hoursePower']; ?></td>
                            <td><?php echo $result[0]['lenght']; ?></td>
                            <td><?php echo $result[0]['width']; ?></td>
                            <td><?php echo $result[0]['description']; ?></td>
                        </tr>
                    </tbody>

                </table>
                <div>
                    <?php
                    $sql = " SELECT * FROM carimage WHERE carID= " . $result[0]['carID'];

                    $statement = $conn->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    echo  $result[0]['carID'];
                    for ($counter = 0; $counter < 3; $counter++) { ?>
                        <img src="<?php echo $result[$counter]['imagePath']; ?>" alt="">

                    <?php }
                    $conn = null;
                    ?>
                </div>
            </div>
        </div>

    </main>
    <footer>
    </footer>
</body>

</html>