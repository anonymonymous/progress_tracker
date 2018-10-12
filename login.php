<!doctype <!DOCTYPE html>

<?php
ini_set('session.cookie_domain', 'localhost'); //set to the server domain to use co-domain access
function customError($errno, $errstr, $err_f, $err_l) {
  echo "<b>Error:</b> [$errno] $errstr $err_f $err_l";
}

//set error handler
set_error_handler("customError");
// //////////////////////////////*******To be removed when login.php is complete*******///////////////////////////////////////////////////////
/* These are our valid username and passwords */
$user = '170050059';
$pass = 'pass';

session_start();
if (isset($_SESSION['username'])) {
	header('location: dashboard.php');
	exit();
}
else if (isset($_COOKIE['username']) && isset($_COOKIE['passwd'])) {
	if (($_COOKIE['username'] == $user) && ($_COOKIE['passwd'] == md5($pass))) {
		$_SESSION['username'] = $_COOKIE['username'];
		header('location: dashboard.php');
		exit();
	}
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['username']) && isset($_POST['passwd'])) {
		if (($_POST['username'] == $user) && ($_POST['passwd'] == $pass)) {    
			
			if (isset($_POST['remember_me'])) {
				/* Set cookie to last 1 year */
				setcookie('username', $_POST['username'], time()+86400*365);
				setcookie('passwd', md5($_POST['passwd']), time()+ 86400*365);
			}
			$_SESSION['username'] = $_POST['username'];
			header('Location: dashboard.php');
			exit();
			
		} else {
			echo '<script>alert("Invalid username or password")</script>';
		}
	}
}
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Voodle</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="login.css" />
	<script src="login.js"></script>
	<script src="assets/particles.min.js"></script>
	<link rel='stylesheet' href='./assets/fonts.css'>
</head>
<body>
	<!-- Login Page -->
	<div id="init_info">
		<!-- Info Content like what the site is about -->
	</div>

	<div id='login'>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<span>Username</span>
			<input type="text" placeholder="CSE LDAP" name="username" id="username" size="15" autocomplete='username' pattern="[A-Za-z_0-9]*" oninput='check_username(this)' required><br>
			<span>Password</span>
			<input type="password" placeholder="Password" name="passwd" id="passwd" autocomplete='current-password' size="15" oninput='check_password(this)' required><br>
			<label class='container'><input type="checkbox" checked="checked" name="remember_me"><span class='checkmark'></span><span style='display: inline-block;'>Remember Me</span></label>
			<input type="submit" value="Login" style="margin: 0; padding: 10px; position: relative; background-color: #ffa500; border: 1px solid red; width: 100%; cursor: pointer;">
		</form>
	</div>
</body>
</html>
