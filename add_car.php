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
                    <li><a href="car.php">Rent Car</a></li>
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

                if ($_SESSION['user'] != 'admin@store.ps') {
                    displayCustomerSideNav();
                } else {
                    displayAdminSideNav();
                } ?>
            </ul>

        </div>
        <div class="main_container">
            <div class="main_item">
                <?php
                function generateCarReferenceNumber()
                {
                    $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $referenceCarNumber = 'sa';

                    $mystr = array($chars);
                    $string = strlen($chars);
                    for ($i = 0; $i < 17; $i++) {
                        echo $chars[rand(0, 17)];
                    }
                }
                function displayAddCarForm1()
                {

                ?>

                    <form id="add_car_form" action="add_car.php" method="POST">
                        <fieldset>
                            <legend>Car Information</legend>
                            <input class="input_field" type="text" name="modelName" placeholder="modelName" required>
                            <input class="input_field" type="text" name="carReferenceNumber" placeholder="carReferenceNumber" value="<?php generateCarReferenceNumber(); ?>" readonly><br>
                            <input class="input_field" type="text" name="year" placeholder="year" required>
                            <input class="input_field" type="text" name="description" placeholder="description" required><br>
                            <input class="input_field" type="text" name="pricePerDay" placeholder="pricePerDay" required>
                            <input class="input_field" type="text" name="manufacturingCountry" placeholder="manufacturingCountry" required><br>
                            <input class="input_field" type="text" name="capacity" placeholder="capacity" required>
                            <input class="input_field" type="text" name="color" placeholder="color" required><br>
                            <input class="input_field" type="text" name="totalPrice" placeholder="totalPrice" required><br>
                            <input class="input_field" type="text" name="avgOfPetroleum" placeholder="avgOfPetroleum" required>
                            <input class="input_field" type="text" name="hoursePower" placeholder="hoursePower" required><br>
                            <input class="input_field" type="text" name="lenght" placeholder="lenght" required>
                            <input class="input_field" type="text" name="width" placeholder="width" required><br>
                            <input type="submit" name="next" value="next">
                        </fieldset>


                    </form>

                <?php
                }
                function displayAddCarForm2()
                {
                ?>
                    <form id="car_image_form" action="add_car.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Car Image</legend>
                            <input class="input_field" type="file" name="file1" required><br>
                            <input class="input_field" type="file" name="file2" required><br>
                            <input class="input_field" type="file" name="file3" required><br>
                            <input type="submit" name="confirm" value="confirm">
                        </fieldset>



                    </form>
                <?php
                }
                function insertCarData()
                {
                    //update data
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'insert into car( year,carReferenceNumber, description, pricePerDay, manufacturingCountry, capacity, color, totalPrice, avgOfPetroleum, hoursePower, lenght, width, modelName) values (  :year, :carReferenceNumber, :description, :pricePerDay, :manufacturingCountry, :capacity, :color, :totalPrice, :avgOfPetroleum, :hoursePower, :lenght, :width, :modelName); ';
                    $statement = $conn->prepare($sql);
                    $statement->execute(array(
                        ':year' => $_SESSION['information']['year'],
                        ':carReferenceNumber' => $_SESSION['information']['carReferenceNumber'],
                        ':description' => $_SESSION['information']['description'],
                        ':pricePerDay' => $_SESSION['information']['pricePerDay'],
                        ':manufacturingCountry' => $_SESSION['information']['manufacturingCountry'],
                        ':capacity' => $_SESSION['information']['capacity'],
                        ':color' => $_SESSION['information']['color'],
                        ':totalPrice' => $_SESSION['information']['totalPrice'],
                        ':avgOfPetroleum' => $_SESSION['information']['avgOfPetroleum'],
                        ':hoursePower' => $_SESSION['information']['hoursePower'],
                        ':lenght' => $_SESSION['information']['lenght'],
                        ':width' => $_SESSION['information']['width'],
                        ':modelName' => $_SESSION['information']['modelName'],

                    ));
                    $conn = null;
                }
                function insetCarImagePath()

                {   //move image 1
                    $file = $_FILES['file1'];
                    $file_store1 = 'car/' . $_FILES['file1']['name'];
                    move_uploaded_file($_FILES['file1']['tmp_name'], $file_store1);
                    //move image 2
                    $file = $_FILES['file2'];
                    $file_store2 = 'car/' . $_FILES['file2']['name'];
                    move_uploaded_file($_FILES['file2']['tmp_name'], $file_store2);
                    //move image 3
                    $file = $_FILES['file3'];
                    $file_store3 = 'car/' . $_FILES['file3']['name'];
                    move_uploaded_file($_FILES['file3']['tmp_name'], $file_store3);
                    //update data
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //inset image 1 
                    $sql = "insert into carimage(carID,imagePath) value(?,?);";
                    $statement = $conn->prepare($sql);
                    $statement->bindValue(1, getCarID());
                    $statement->bindValue(2, $file_store1);
                    $statement->execute();
                    //inset image 2 
                    $sql = "insert into carimage(carID,imagePath) value(?,?);";
                    $statement = $conn->prepare($sql);
                    $statement->bindValue(1, getCarID());
                    $statement->bindValue(2, $file_store2);
                    $statement->execute();
                    //inset image 3 
                    $sql = "insert into carimage(carID,imagePath) value(?,?);";
                    $statement = $conn->prepare($sql);
                    $statement->bindValue(1, getCarID());
                    $statement->bindValue(2, $file_store3);
                    $statement->execute();
                    $conn = null;
                }
                function getCarID()
                {
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "select carID from `car` where carReferenceNumber='" . $_SESSION['information']['carReferenceNumber'] . "'";
                    $result = $conn->query($sql);
                    $isUser = false;

                    while ($row = $result->fetch()) {
                        return $row['carID'];
                    }
                }

                if (!isset($_POST['next']) && !isset($_POST['confirm'])) {
                    displayAddCarForm1();
                } else if (isset($_POST['next']) && !isset($_POST['confirm'])) {
                    //store data in session
                    foreach ($_POST as $key => $value) {
                        $_SESSION['information'][$key] = $value;
                    }
                    //delete next as key
                    unset($_SESSION['information']['next']);
                    displayAddCarForm2();
                } else if (isset($_POST['confirm'])) {
                    insertCarData();
                    insetCarImagePath();
                }
                ?>
            </div>
            
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>