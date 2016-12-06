<?php 
session_start(); 
include 'admin_anti_brute_force.php';
$deny_login = Services::bruteCheck();
$incorrect_login = false;
$login_err = "";
if($deny_login) {
    $login_err = "Login locked. Try again in 15 minutes.";
} else {
    if (isset($_POST['username']) && isset($_POST['password'])) {	
        if (($_POST['username'] == 'mbcadmin') && ($_POST['password'] == 'somepass...')) {
            $_SESSION['login_success'] = true;
            header('Location: http://midcoastbaptistchurch.com/admin/index.php');
            exit();  
        }
        else {
            $incorrect_login = true;
        }
    }
    if($incorrect_login) {
        Services::bruteCheck(true);
        $login_err = "Invalid username or password!";
    } 
}
?>
<html> 
    <head>
        <title>Admin Login</title>
        <style>
            div {
                text-align:center;
                margin:40px;
            }
            h1 {
            	font:16px;
            }
            h2 {
                font: 12px;
                color: red;
            }
            fieldset {
                margin:auto;
                width:700px;
            }
        </style>
    </head>
    <body id="page1">
        <!-- Login Dialog -->
        <div>
            <h1>MBC Administration Login</h1>
	    <?php 
		if($login_err != "") {
		    echo "<h2>" . $login_err . "</h2><br>"; 
		}
	    ?> 
            <form method="post" action="">
                <fieldset>
                    <label>
                        <span>Username</span>
                        <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Username">
                    </label>
                    <label>
                        <span>Password</span>
                        <input id="password" name="password" value="" type="password" placeholder="Password">
                    </label>
                    <button type="submit">Sign in</button>       
                    <a href="/index.php">Cancel</a>
                </fieldset>
            </form>
        </div>
    </body>
</html>
