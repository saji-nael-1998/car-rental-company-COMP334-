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
        function displayUserForm()
        {
        ?>
            <div id="account_form_container">
                <form id="account_form" action="form_2.php" method="POST">
                    <fieldset>
                        <legend>Account Information</legend>
                        <label>User:</label><br>
                        <input type="text" name="username" placeholder="username" minlength="3" maxlength="20" required><br>
                        <label>Password:</label><br>
                        <input type="password" name="pass" placeholder="password"  required><br>
                        <input type="submit" name="confirm" value="confirm">
                    </fieldset>


                </form>
            </div>
        <?php
        }
        function createCustomer()
        {

            try {
                $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "insert into customer(customerID, FName, MName, LName, city, street, dateOfBirth,
                 ID, email, mobile, username, pass, telephone)
                  values (:customerID, :FName, :MName, :LName, :city, :street, :dateOfBirth, :ID, 
                  :email,:mobile, :username, :pass, :telephone);";
                $statement = $conn->prepare($sql);
                
                $statement->execute(array(
                    ':customerID' => $_SESSION['information']['customerID'],
                    ':FName' => $_SESSION['information']['FName'],
                    ':MName' => $_SESSION['information']['MName'],
                    ':LName' => $_SESSION['information']['LName'],
                    ':city' => $_SESSION['information']['city'],
                    ':street' => $_SESSION['information']['street'],
                    ':dateOfBirth' => $_SESSION['information']['dateOfBirth'],
                    ':ID' => $_SESSION['information']['ID'],
                    ':email' => $_SESSION['information']['email'],
                    ':mobile' => $_SESSION['information']['mobile'],
                    ':username' => $_SESSION['information']['username'],
                    ':pass' => $_SESSION['information']['pass'],
                    ':telephone' => $_SESSION['information']['telephone']
                ));
                echo $statement;
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        function displayConfirmationForm()
        {
        ?>

            <div id="account_form_container">
                <form id="account_form" action="form_2.php">
                    <label >Hi,<?php echo $_SESSION['information']['FName'] . ' ' . $_SESSION['information']['LName']; ?> </label><br>
                    <label >Username:</label><br>
                    <input  type="text" value="<?php echo $_SESSION['information']['username']; ?> " readonly><br>
                    <label >Customer ID: </label><br>
                    <input  type="text" value="<?php echo $_SESSION['information']['customerID']; ?>" readonly><br>
                    <a href="login.php">go to login</a>
                </form>
            </div>

        <?php }

        if (!isset($_POST['confirm'])) {
            displayUserForm();
        } else {
            //store data in session
            $_SESSION['information']['customerID'] = rand(111111111, 999999999);
            foreach ($_POST as $key => $value) {
                $_SESSION['information'][$key] = $value;
            }
            //delete next as key
            unset($_SESSION['information']['confirm']);
            //create a new customer
            createCustomer();
            //display confirmation form
            displayConfirmationForm();
            //clear session
            unset($_SESSION['information']);
        }
        ?>
    </main>
    <footer>
    </footer>
</body>

</html>