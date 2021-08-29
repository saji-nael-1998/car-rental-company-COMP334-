<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['user'])) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    // Append the host(domain name, ip) to the URL.   
    $url .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL   
    $url .= $_SERVER['REQUEST_URI'];
    
    $url = explode('/', $url);
  
    $_SESSION['current_url'] = $url[5];

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
                function displayRentForm()
                {
                ?>
                    <form id="rent_form" action="rent_car.php" method="POST">
                        <fieldset>
                            <legend>Rent Form</legend>
                            <label class="customized_label">rent Date:</label><br>
                            <label>from :</label> <input type="datetime-local" name="rentalStartdate" required>&nbsp;&nbsp;&nbsp;
                            <label>to :</label> <input type="datetime-local" name="rentalEnddate" required><br>
                            <br>
                            <label class="customized_label">Card Information : </label><br>
                            <label for="">Name :</label>
                            <input type="text" name="nameCard"><br>
                            <label for="">Bank :</label>
                            <input type="text" name="bankIssued"><br>
                            <label>visa type:</label><br>
                            <input type="radio" name="card" value="111" checked>
                            <label for="age1">VISA</label><br>
                            <input type="radio" name="card" value="222">
                            <label for="age2">MasterCard</label><br>
                            <input type="radio" name="card" value="333">
                            <label for="age3">American Express</label><br>
                            <input type="text" name="numberCard" placeholder="insert 6 digits" required><br>
                            <label for="">Expire Date :</label><br>
                            <input type="text" name="MExpireDate" placeholder="mm" required> <input name="YExpireDate" type="text" placeholder="yy" required>
                            <br>
                            <input type="submit" name="next" value="next">
                        </fieldset>
                    </form>
                <?php

                }
                function confirmRentForm()
                { ?>
                    <form id="rent_form" action="rent_car.php" method="POST">
                        <fieldset>
                            <legend>Rent Confirmation</legend><br>
                            <br> <label>Car Reference Number:</label><br>
                            <input type="text" value="<?php echo $_SESSION['information']['carReferenceNumber']; ?>" readonly><br>
                            <br> <label>Rent Date & time</label><br>
                            <input type="datetime-local" value="<?php echo $_SESSION['information']['rentalStartdate']; ?>" readonly>&nbsp;<label for="">TO:</label>>&nbsp;<input type="datetime-local" value="<?php echo $_SESSION['information']['rentalEnddate']; ?>" readonly><br>
                            <br> <label>Total Money:</label><br>
                            <input type="text" value="<?php echo   $_SESSION['information']['total']; ?>" readonly><br>
                            <input type="submit" name="confirm" value="confirm">
                        </fieldset>
                    </form>
                <?php
                }
                function confirmRent()
                {

                    //update data
                    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'INSERT INTO rental( carID, customerID, rentalStartdate, rentalEnddate, numberCard , nameCard,bankIssued, MExpireDate, YExpireDate) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?) ';

                    $statement = $conn->prepare($sql);
                    $_SESSION['information']['rentalEnddate'] = str_replace('T', ' ', $_SESSION['information']['rentalEnddate']);
                    $_SESSION['information']['rentalStartdate'] = str_replace('T', ' ', $_SESSION['information']['rentalStartdate']);

                    $statement->bindValue(1, $_SESSION['information']['carID']);
                    $statement->bindValue(2, $_SESSION['customerID']);
                    $statement->bindValue(3, $_SESSION['information']['rentalStartdate']);
                    $statement->bindValue(4, $_SESSION['information']['rentalEnddate']);
                    $statement->bindValue(5, $_SESSION['information']['numberCard']);
                    $statement->bindValue(6, $_SESSION['information']['nameCard']);
                    $statement->bindValue(7, $_SESSION['information']['bankIssued']);
                    $statement->bindValue(8, $_SESSION['information']['MExpireDate']);
                    $statement->bindValue(9, $_SESSION['information']['YExpireDate']);
                    $statement->execute();
                    $conn = null;
                }

                if (!isset($_POST['next']) && !isset($_POST['confirm'])) {
                    //store data in session
                    foreach ($_GET as $key => $value) {
                        $_SESSION['information'][$key] = $value;
                    }
                    displayRentForm();
                } else if (isset($_POST['next']) && !isset($_POST['confirm'])) {
                    //store data in session
                    foreach ($_POST as $key => $value) {
                        $_SESSION['information'][$key] = $value;
                    }
                    $diff = strtotime($_POST['rentalEnddate']) - strtotime($_POST['rentalStartdate']);

                    $_SESSION['information']['total'] = ($diff / 86400) * $_SESSION['information']['pricePerDay'];
                    //delete next as key
                    unset($_SESSION['information']['next']);
                    confirmRentForm();
                } else if (isset($_POST['confirm'])) {
                    confirmRent();
                }
                ?>
            </div>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>