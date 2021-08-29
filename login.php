<?php
session_start();
require_once('config.php');
if (isset($_SESSION['user'])) {
    header("location: index.php");
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
                <li><a href="form_1.php">Register</a></li>
                <li><a href="login.php">Login </a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php function displayLoginForm($username, $password)
        {
        ?>
            <div id="login_container">
                <figure>
                    <img src="images/saji.jpg" alt="">
                    <figcaption>
                       &nbsp; Saji Nael 
                        1161941
                    </figcaption>
                </figure>
                <form id="login_form" action="login.php" method="POST">
                    <fieldset>
                        <legend>Welcome</legend>
                        <label class="input_label">Username</label><br>
                        <input class="input_field" type="text" name="username" value="<?php echo $username ?>" required><br>
                        <label class="input_label">Password</label><br>
                        <input class="input_field" type="password" name="password" value="<?php echo $password ?>" required><br>
                        <input type="submit" name="submit" value="login"><br>
                        <label id="sign_up_title">Not a member?</label>&nbsp;<a id="sign_up" href="form_1.php">sign up now</a>
                    </fieldset>

                </form>
            </div>



        <?php
        }
        function checkUser($username, $password)
        {

            try {


                $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "select * from `customer`";
                $result = $conn->query($sql);
                $isUser = false;

                while ($row = $result->fetch()) {
                    if ($row['username'] == $username && $row['pass'] == $password) {
                        $isUser = true;
                        $_SESSION['user'] = $username;
                        $_SESSION['customerID'] = $row['customerID'];
                        setcookie("user",   $username, time() + (86400 * 30));
                        setcookie("customerID", $row['customerID'], time() + (86400 * 30));
                        setcookie("pass", $password, time() + (86400 * 30));

                        break;
                    }
                }

                if ($isUser) {
                    if (isset($_SESSION['current_url'])) {
                        $u = $_SESSION['current_url'];
                        echo $u;
                        header("location: " . $u);
                        unset($_SESSION['current_url']);
                        exit;
                    } else if (isset($_SESSION['search_car'])) {
                        unset($_SESSION['search_car']);
                        header("location: search.php");
                    } else {
                        header("location: index.php");
                        exit;
                    }
                } else {
                    if ($username == 'admin@store.ps' && $password=='hello') {
                        $_SESSION['user'] = $username;
                        setcookie("user",   $_SESSION['user'], time() + (86400 * 30));
                       
                        header('location: index.php');

                        exit;
                    } else {

                         echo '<script>alert("Please, check inputs")</script>';
                        displayLoginForm('', '');
                    }
                }
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        ?>
        <?php
        //check login
        if (!isset($_POST['submit'])) {
            displayLoginForm("", "");
        } else {

            checkUser($_POST['username'], $_POST['password']);
        }
        ?>
    </main>

</body>

</html>