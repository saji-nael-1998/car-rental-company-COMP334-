<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['user'])) {
    header("location: login.php");
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
                <li><a href="#">Cars</a></li>
                <li><a href="#">Search</a></li>
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
                function displayCustomerProfileForm()
                {

                    //fetch data 
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "select * from `customer` where customerID=" . $_SESSION['customerID'];
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    $result = $statement->fetchAll();
                    $conn = null;

                ?>
                    <form id="update_customer_form" action="customer_profile.php" method="POST">
                        <fieldset>
                            <legend>Update</legend>
                            <label class="input_label">Name:</label><br>
                        <input class="input_field" type="text" name="FName" placeholder="first name" value="<?php echo $result[0]['FName'] ?>" required>
                        <input class="input_field" type="text" name="MName" placeholder="mid name" value="<?php echo $result[0]['MName'] ?>" required>
                        <input class="input_field" type="text" name="LName" placeholder="last name" value="<?php echo $result[0]['LName'] ?>" required>
                        <br>
                        <label class="input_label">Address:</label><br>
                        <input class="input_field" type="text" name="street" placeholder="street" value="<?php echo $result[0]['street'] ?>" required>
                        <input class="input_field" type="text" name="city" placeholder="city" value="<?php echo $result[0]['city'] ?>" required>
                        <br>
                        <label class="input_label">Details:</label><br>
                        <input class="input_field" type="date" name="dateOfBirth" value="<?php echo $result[0]['dateOfBirth'] ?>" required>
                        <input class="input_field" type="text" name="ID" pattern="[0-9]{9}" value="<?php echo $result[0]['ID'] ?>" placeholder="ID" required>
                        <br>

                        <br>
                        <label class="input_label">Contact:</label><br>
                        <input class="input_field" type="email" name="email" value="<?php echo $result[0]['email'] ?>" placeholder="email" required>
                        <input class="input_field" type="tel" name="mobile" pattern="[0-9]{4}[0-9]{6}" value="<?php echo '0' . $result[0]['mobile'] ?>" placeholder="mobile ex:05########" required>
                        <input class="input_field" type="text" name="telephone" pattern="02[0-9]{7}" value="<?php echo '0' . $result[0]['telephone'] ?>" placeholder="telephone ex: 022######" required>
                        <br>
                        <label class="input_label">Account Details:</label><br>
                        <input class="input_field" type="text" name="username" value="<?php echo $result[0]['username'] ?>" placeholder="street" required readonly>
                        <input class="input_field" type="text" name="customerID" value="<?php echo $result[0]['customerID'] ?>" placeholder="street" required readonly>

                        <input class="input_field" type="text" name="pass" placeholder="city" value="<?php echo $result[0]['pass'] ?>" required><br>

                        <input type="submit" name="update" value="update">
                        </fieldset>
                        

                    </form>


                <?php
                }
                if (!isset($_POST['update'])) {
                    displayCustomerProfileForm();
                } else {
                    //update data
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'update customer set FName = ?, MName = ?, LName = ?, city = ?, street = ?, dateOfBirth = ?, ID = ?, email = ?, mobile = ?, username = ?, pass = ?, telephone = ? where customerID = ?; ';
                    $statement = $conn->prepare($sql);
                    $statement->bindValue(1, $_POST['FName']);
                    $statement->bindValue(2, $_POST['MName']);
                    $statement->bindValue(3, $_POST['LName']);
                    $statement->bindValue(4, $_POST['city']);
                    $statement->bindValue(5, $_POST['street']);
                    $statement->bindValue(6, $_POST['dateOfBirth']);
                    $statement->bindValue(7, $_POST['ID']);
                    $statement->bindValue(8, $_POST['email']);
                    $statement->bindValue(9, $_POST['mobile']);
                    $statement->bindValue(10, $_POST['username']);
                    $statement->bindValue(11, $_POST['pass']);
                    $statement->bindValue(12, $_POST['telephone']);
                    $statement->bindValue(13, $_POST['customerID']);
                    $statement->execute();
                    $conn = null;
                    unset($_POST['update']);
                    header('location: customer_profile.php');
                }
                ?>

            </div>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>