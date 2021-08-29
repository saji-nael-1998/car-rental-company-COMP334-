<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['search_car'] = 1;
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
                } ?>
            </ul>

        </div>
        <div class="main_container">
            <div class="main_item">
                <form id="search_form" action="search.php" method="GET">
                    <fieldset>
                        <legend>Search</legend>
                        <!--filter section-->
                        <div id="filter_section">
                            <label for="rent_date">Rent Date :</label><br>
                            <input type="date" value="<?php
                                                        echo  date("Y-m-d");

                                                        ?>" name="rentalStartdate"><br>
                            <label>Rent Date :</label><br>
                            <select name="modelName" id="model">
                                <option value="no_model">select model:</option>
                                <?php
                                //fetch data 
                                $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = " SELECT * FROM car GROUP BY manufacturingCountry";
                                $statement = $conn->prepare($sql);
                                $statement->execute();
                                $result = $statement->fetchAll();
                                $conn = null;
                                for ($counter = 0; $counter < sizeof($result); $counter++) {
                                ?>
                                    <option value="<?php echo $result[$counter]['modelName']; ?>">

                                        <?php
                                        $arr = explode(' ', $result[$counter]['modelName']);
                                        echo $arr[0];
                                        ?>
                                    </option>
                                <?php
                                } ?>

                            </select>
                            <select name="year" id="year">
                                <option value="no_year">select year:</option>
                                <?php

                                for ($counter = 2008; $counter < 2022; $counter++) {
                                ?>
                                    <option value="<?php echo $counter; ?>">

                                        <?php echo $counter; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                            <select name="manufacturingCountry" id="manufacturingCountry">
                                <option value="no_country">select country:</option>
                                <?php for ($counter = 0; $counter < sizeof($result); $counter++) {
                                ?>
                                    <option value="<?php echo $result[$counter]['manufacturingCountry']; ?>">

                                        <?php

                                        echo  $result[$counter]['manufacturingCountry'];
                                        ?>
                                    </option>
                                <?php
                                } ?>
                            </select><br>
                            <label>Price Range :</label><br>
                            <label>from : </label>
                            <input type="text" value="0" name="from">
                            <label>to :</label>
                            <input type="text" value="0" name="to"><input type="submit" name="search" value="search">
                        </div>
                        <div id="search_table_container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Car reference number</th>
                                        <th>model</th>
                                        <th>year</th>
                                        <th> price per day</th>
                                        <th>description </th>
                                        <th>option</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    function getData($query)
                                    {
                                        $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $statement = $conn->prepare($query);
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


                                                        <a href="car_view.php?carReferenceNumber=<?php echo $result[$counter]['carReferenceNumber']; ?>" target="_blank">View</a>
                                                        <?php
                                                        if ($_SESSION['user'] != 'admin@store.ps') {
                                                        ?>

                                                            <a href="rent_car.php?carReferenceNumber=<?php echo $result[$counter]['carReferenceNumber'] . "&carID=" . $result[$counter]['carID'] . "&pricePerDay=" . $result[$counter]['pricePerDay']; ?>" target="_blank">rent</a>


                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                </td>

                                            </tr>


                                    <?php
                                        }
                                    } ?>
                                    <?php


                                    //fetch result
                                    if (isset($_GET['search'])) {
                                        unset($_GET['search']);
                                        $isMultiCondition = 0;
                                        $query = "SELECT * FROM car  ";
                                        //check the value of from and to
                                        if ($_GET['from'] < $_GET['to']) {
                                            if ($isMultiCondition == 0) {
                                                $query = $query . " WHERE ";
                                            }
                                            $query = $query . "pricePerDay between  " . $_GET['from'] . " and " . $_GET['to'] . "   ";
                                            unset($_GET['from']);
                                            unset($_GET['to']);
                                            $isMultiCondition = $isMultiCondition + 1;
                                        } else {
                                            unset($_GET['from']);
                                            unset($_GET['to']);
                                        }

                                        //check values of input
                                        foreach ($_GET as $key => $value) {

                                            if ($value == 'no_model' || $value == 'no_country' || $value == 'no_year' || strlen($value) == 0) {
                                                continue;
                                            } else {
                                                if ($key == 'modelName' || $key == 'manufacturingCountry') {

                                                    //add where to query
                                                    if ($isMultiCondition == 0) {
                                                        $query = $query . " WHERE ";
                                                    }
                                                    //check if there is multi query
                                                    if ($isMultiCondition > 0) {
                                                        $query = $query . " and" . " " . $key . " like '" . $value . "%'";
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    } else {
                                                        $query = $query . " " . $key . " like '" . $value . "%'";
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    }
                                                } else if ($key == 'rentalStartdate') {

                                                    //add where to query
                                                    if ($isMultiCondition == 0) {
                                                        $query = $query . " WHERE ";
                                                    }
                                                    //check if there is multi query
                                                    if ($isMultiCondition > 0) {
                                                        $value = str_replace('T', ' ', $value);
                                                        $query = $query . " and" . " " . " NOT EXISTS (SELECT carID FROM rental WHERE rental.carID = car.carID and rental.rentalEnddate > '$value' )";
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    } else {
                                                        $value = str_replace('T', ' ', $value);

                                                        $query = $query . " " . " NOT EXISTS (SELECT carID FROM rental WHERE rental.carID = car.carID and rental.rentalEnddate > '$value' )";
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    }
                                                } else {
                                                    //add where to query
                                                    if ($isMultiCondition == 0) {
                                                        $query = $query . " WHERE ";
                                                    } //check if there is multi query
                                                    if ($isMultiCondition > 0) {
                                                        $query = $query . " and" . " " . $key . " = " . $value;
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    } else {
                                                        $query = $query . " " . $key . " = " . $value;
                                                        $isMultiCondition = $isMultiCondition + 1;
                                                    }
                                                }
                                            }
                                        }

                                        getData($query);
                                    }
                                    ?>
                                </tbody>
                        </div>

                        </table>

                    </fieldset>
                </form>



            </div>

        </div>

    </main>

</body>

</html>