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
                <li><a href="form_1.php">Register</a></li>
                <li><a href="login.php">Login </a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        function displayPersonalForm()
        {
        ?>

            <div id="personal_container">
                <form id="personal_form" action="form_1.php" method="POST">
                    <fieldset>
                        <legend>Personal Information</legend>
                        <label>Name:</label><br>
                        <input type="text" name="FName" placeholder="first name" required>
                        <input type="text" name="MName" placeholder="mid name" required><br>
                        <input type="text" name="LName" placeholder="last name" required>
                        <br>
                        <label>Address:</label><br>
                        <input type="text" name="street" placeholder="street" required>
                        <input type="text" name="city" placeholder="city" required>
                        <br>
                        <label>Details:</label><br>
                        <input type="date" name="dateOfBirth" required>
                        <input type="text" name="ID" pattern="[0-9]{9}" placeholder="ID" required>
                        <br>

                        <br>
                        <label>Contact:</label><br>
                        <input type="email" name="email" placeholder="email" required>
                        <input type="tel" name="mobile" pattern="[0-9]{4}[0-9]{6}" placeholder="mobile ex:05########" required><br>
                        <input type="text" name="telephone" pattern="02[0-9]{7}" placeholder="telephone ex: 022######" required>
                        <br>
                        <input type="submit" name="next" value="next">
                    </fieldset>


                </form>
            </div>
          
        <?php
        }
        if (!isset($_POST['next'])) {
            displayPersonalForm();
        } else {
            //store data in session
            foreach ($_POST as $key => $value) {
                $_SESSION['information'][$key] = $value;
            }
            //delete next as key
            unset($_SESSION['information']['next']);
            //direct user to next section
            header("location: form_2.php");
        }
        ?>

    </main>

</body>

</html>