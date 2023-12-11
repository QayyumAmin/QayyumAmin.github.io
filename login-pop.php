<?PHP $error = ""; ?>
<div id="idSuccessLogin" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idSuccessLogin').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Success</b>
			  
			<hr class="w3-clear">
			
			Successfully login.
			
			<div class="w3-padding-16"></div>
			
			<a href="index.php" onclick="document.getElementById('idSuccessLogin').style.display='none'; self.location='index.php'" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">CONTINUE <i class="fa fa-fw fa-lg fa-chevron-right"></i></a>

		</form>
		</div>
	</div>
</div>

<div id="idErrorLogin" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idErrorLogin').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding w3-center">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Error</b>
			  
			<hr class="w3-clear">
			
			Invalid login.
			
			<div class="w3-padding-16"></div>
			
			<!--<a onclick="document.getElementById('idErrorLogin').style.display='none'; document.getElementById('idLogin').style.display='block';'" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">RETRY <i class="fa fa-fw fa-lg fa-history"></i></a>-->

		</form>
		</div>
	</div>
</div>
<?PHP 
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$level 		= (isset($_POST['level'])) ? trim($_POST['level']) : 'company';
$company_name= (isset($_POST['company_name'])) ? trim($_POST['company_name']) : '';
$name 		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$gender 	= (isset($_POST['gender'])) ? trim($_POST['gender']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password 	= (isset($_POST['passwordx'])) ? trim($_POST['passwordx']) : '';
$password_admin 	= (isset($_POST['password_admin'])) ? trim($_POST['password_admin']) : '';
$username 	= (isset($_POST['username'])) ? trim($_POST['username']) : '';

$suc_login = "";

if($act == "login") 
{
	$SQL_login = " SELECT * FROM `user` WHERE `email` = '$email' AND BINARY `password` = '$password'  ";

	$result = mysqli_query($con, $SQL_login);
	$data_login	= mysqli_fetch_array($result);

	$valid = mysqli_num_rows($result);

	if($valid > 0)
	{
		$_SESSION["email"] = $email;
		$_SESSION["password"] = $password;
		$_SESSION["id_user"] = $data_login["id_user"];
		
		//header("Location:main.php");
		//print "<script>self.location='order-add.php';</script>";
		print "<script>document.getElementById('idSuccessLogin').style.display='block';</script>";
	}else{
		$error = "Invalid";
		print "<script>document.getElementById('idErrorLogin').style.display='block';</script>";
		//header( "refresh:1;url=index.php" );
		//print "<script>alert('Invalid!'); self.location='index.php';</script>";
	}
}

if($act == "loginAdmin") 
{
	$SQL_login = " SELECT * FROM `$level` WHERE `username` = '$username' AND `password` = '$password_admin'  ";

	$result = mysqli_query($con, $SQL_login);
	$data_login	= mysqli_fetch_array($result);

	$valid = mysqli_num_rows($result);

	if($valid > 0)
	{		
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password_admin;
		//header("Location:a-main.php");
		if($level == "admin"){
			print "<script>self.location='a-main.php';</script>";
		} else {
			$_SESSION["id_company"] = $data_login["id_company"];
			print "<script>self.location='c-main.php';</script>";
		}

	}else{
		$error = "Invalid";
		print "<script>document.getElementById('idErrorLogin').style.display='block';</script>";
		//header( "refresh:1;url=index.php" );
		//print "<script>alert('Invalid!'); self.location='index.php';</script>";
	}
}
?>

<?PHP
if($act == "addRegister")
{
	$found 	= numRows($con, "SELECT * FROM `user` WHERE `email` = '$email' ");
	if($found) $error ="Email already registered";

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		$error = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
	}
}
?>
<div id="idRegUser" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
	<header class="w3-container w3-center"> 
		<span onclick="document.getElementById('idRegUser').style.display='none'" 
		class="w3-button w3-display-topright w3-circle">&times;</span>
		<div class="w3-padding"></div>
		Sign up new account
	</header>
	<hr>
	<div class="w3-container">

<?PHP if($error) { ?>
	<div class="w3-content w3-container w3-white w3-text-red w3-round-large w3-border w3-border-red" style="max-width:600px">
		<div class="w3-padding">
		<div class="w3-large">Error!</div>
		<?PHP echo $error;?>
		</div>
	</div>
<?PHP } ?>

		<div class="w3-container w3-padding">
		<form action="" method="post">
			<div class="w3-section" >				
				<input class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $name;?>" placeholder="Name *" required>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-round" type="tel" name="phone" pattern="^(\+?6?01)[01-46-9]-*[0-9]{7}$|^(\+?6?01)[1]-*[0-9]{8}$" placeholder="Mobile Phone *   e.g: 60191234567" value="<?PHP echo $phone;?>" required>
			</div>
			
			<div class="w3-section" >
				<select class="w3-select w3-border w3-round" name="gender"  required>
					<option value="">- Select Gender -</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-round" type="email" name="email" value="<?PHP echo $email;?>" placeholder="Email *" required>
			</div>
			
			<div class="w3-section">
				<input class="w3-input w3-border w3-round" type="password" name="passwordx" id="password" maxlength="20" placeholder="Password *" required>
				<div class="w3-text-gray w3-small" style="line-height: 1.1;" >Password must have at least 8-12 Characters with 1 Capital Letter and 1 Number Characters.</div>
				<div class="w3-padding "><input type="checkbox" onclick="myFunction()"> Show Password</div>
			</div>
			
			<script>
			function myFunction() {
			  var x = document.getElementById("password");
			  if (x.type === "password") {
				x.type = "text";
			  } else {
				x.type = "password";
			  }
			}
			</script>

			<input name="act" type="hidden" value="addRegister">
			<button type="reset" class="w3-button w3-padding-large w3-amber w3-wide w3-margin-bottom w3-round"><i class="fa fa-fw fa-history"></i>Reset</button>
			<button type="submit" class="w3-button w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">Register</button>
		</form> 
		</div>
		
		<div class="w3-center">Already registered? <a href="#" onclick="document.getElementById('idLogin').style.display='block';
		 document.getElementById('idRegUser').style.display='none'" class="w3-text-red">Login Here</a></div>
    </div>
	
	<div class="w3-padding"></div>	

    </div>
</div>


<?PHP
if($act == "addRegisterCompany")
{
	$found 	= numRows($con, "SELECT * FROM `company` WHERE `username` = '$username' ");
	if($found) $error ="Username already registered";

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		$error = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
	}
}
?>
<div id="idRegCompany" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
	<header class="w3-container w3-center"> 
		<span onclick="document.getElementById('idRegCompany').style.display='none'" 
		class="w3-button w3-display-topright w3-circle">&times;</span>
		<div class="w3-padding"></div>
		Sign up new account
	</header>
	<hr>
	<div class="w3-container">

<?PHP if($error) { ?>
	<div class="w3-content w3-container w3-white w3-text-red w3-round-large w3-border w3-border-red" style="max-width:600px">
		<div class="w3-padding">
		<div class="w3-large">Error!</div>
		<?PHP echo $error;?>
		</div>
	</div>
<?PHP } ?>

		<div class="w3-container w3-padding">
		<div class="w3-large"><b>Register Company</b></div>
		<form action="" method="post">
			<div class="w3-section" >				
				<input class="w3-input w3-border w3-round" type="text" name="company_name" value="<?PHP echo $company_name;?>" placeholder="Company Name *" required>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $username;?>" placeholder="Username *" required>
			</div>
			
			<div class="w3-section">
				<input class="w3-input w3-border w3-round" type="password" name="passwordx" id="passwordx" maxlength="20" placeholder="Password *" required>
				<div class="w3-text-gray w3-small" style="line-height: 1.1;" >Password must have at least 8-12 Characters with 1 Capital Letter and 1 Number Characters.</div>
				<div class="w3-padding "><input type="checkbox" onclick="myFunction2()"> Show Password</div>
			</div>
			
			<script>
			function myFunction2() {
			  var x = document.getElementById("passwordx");
			  if (x.type === "password") {
				x.type = "text";
			  } else {
				x.type = "password";
			  }
			}
			</script>

			<input name="act" type="hidden" value="addRegisterCompany">
			<button type="reset" class="w3-button w3-padding-large w3-amber w3-wide w3-margin-bottom w3-round"><i class="fa fa-fw fa-history"></i>Reset</button>
			<button type="submit" class="w3-button w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">Register</button>
		</form> 
		</div>
		
		<div class="w3-center">Already registered? <a href="#" onclick="document.getElementById('idLoginAdmin').style.display='block';
		 document.getElementById('idRegCompany').style.display='none'" class="w3-text-red">Login Here</a></div>
    </div>
	
	<div class="w3-padding"></div>	

    </div>
</div>

<div id="idLogin" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container w3-center"> 
        <span onclick="document.getElementById('idLogin').style.display='none'" 
        class="w3-button w3-display-topright w3-circle">&times;</span>
        <h2><img src="images/logo.png" width="200px"></h2>
		Sign in to your account
      </header>
	  <hr>
      <div class="w3-container w3-margin">
		<div class="w3-large"><b>Login User</b></div>
		<form action="" method="post">
			  <div class="w3-section" >
				<label>Email *</label>
				<input class="w3-input w3-border w3-round" type="email" name="email"  required>
			  </div>
			  <div class="w3-section">
				<label>Password *</label>
				<input class="w3-input w3-border w3-round" type="password" name="passwordx" maxlength="20"  required>
			  </div>
			  <input name="act" type="hidden" value="login">
			  <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">Login</button>
		</form>  
		<div class="w3-center">Don't have an account? <a href="#" onclick="document.getElementById('idLogin').style.display='none';
		 document.getElementById('idRegUser').style.display='block';" class="w3-text-red">Register Now!</a></div>
		 
		 <div class="w3-center"><a href="#" onclick="document.getElementById('idLogin').style.display='none';
		 document.getElementById('idForgotUser').style.display='block';" class="w3-text-red">Forgot Password</a></div>
      </div>
		
      <footer class="w3-container ">
		&nbsp;
		<div class="w3-center w3-padding-16 w3-text-red"><a href="#" onclick="document.getElementById('idLogin').style.display='none';
		 document.getElementById('idLoginAdmin').style.display='block';">Login Company / Admin</a></div>
      </footer>
    </div>
</div>

<div id="idLoginAdmin" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container w3-center"> 
        <span onclick="document.getElementById('idLoginAdmin').style.display='none'" 
        class="w3-button w3-display-topright w3-circle">&times;</span>
        <h2><img src="images/logo.png" width="200px"></h2>
		Administrator Sign in
      </header>
	  <hr>
      <div class="w3-container w3-margin">
		<div class="w3-large"><b>Login Administrator</b></div>
		<form action="" method="post">
			  <div class="w3-section" >
				<label>Level *</label>
				<select class="w3-input w3-border w3-round" type="text" name="level"  required>
					<option value="company">Company</option>
					<option value="admin">Admin</option>
				</select>
			  </div>
			  <div class="w3-section" >
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="text" name="username"  required>
			  </div>
			  <div class="w3-section">
				<label>Password *</label>
				<input class="w3-input w3-border w3-round" type="password" name="password_admin" maxlength="20"  required>
			  </div>
			  <input name="act" type="hidden" value="loginAdmin">
			  <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">Login</button>
		</form>
		<div class="w3-center">Don't have an account? <a href="#" onclick="document.getElementById('idLoginAdmin').style.display='none';
		 document.getElementById('idRegCompany').style.display='block';" class="w3-text-red">Register Company!</a></div>		
      </div>
		
      <footer class="w3-container ">
		<div class="w3-center w3-padding-16 w3-text-red"><a href="#" onclick="document.getElementById('idLoginAdmin').style.display='none';
		 document.getElementById('idLogin').style.display='block';">Login User</a></div>
      </footer>
    </div>
</div>

<div id="idSuccessRegister" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idSuccessRegister').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Congratulation</b>
			  
			<hr class="w3-clear">
			
			Your account registered successfully! Please login.
			
			<div class="w3-padding-16"></div>
			
			<a onclick="document.getElementById('idSuccessRegister').style.display='none'; document.getElementById('idLogin').style.display='block'" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round"><i class="fa fa-fw fa-lg fa-lock"></i>   LOGIN</a>
		</form>
		</div>
	</div>
</div>

<div id="idSuccessRegisterCompany" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idSuccessRegisterCompany').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Congratulation</b>
			  
			<hr class="w3-clear">
			
			Your account registered successfully! Please login.
			
			<div class="w3-padding-16"></div>
			
			<a onclick="document.getElementById('idSuccessRegisterCompany').style.display='none'; document.getElementById('idLoginAdmin').style.display='block'" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round"><i class="fa fa-fw fa-lg fa-lock"></i>   LOGIN</a>
		</form>
		</div>
	</div>
</div>

<?PHP
// Register User
if(($act == "addRegister") && ($error))
{
	print "<script>document.getElementById('idRegUser').style.display='block';</script>";
}

if(($act == "addRegister") && (!$error))
{	
	$SQL_insert = " 
	INSERT INTO `user`(`id_user`, `name`, `phone`, `gender`, `email`, `password`, `resume`, `photo`) 
			VALUES (NULL, '$name', '$phone', '$gender', '$email', '$password', '', '') ";
										
	$result = mysqli_query($con, $SQL_insert);

	$suc_login = "Successfully Registered";
	//echo $SQL_insert ;  exit;
	print "<script>document.getElementById('idSuccessRegister').style.display='block';</script>";
}


// Register Company
if(($act == "addRegisterCompany") && ($error))
{
	print "<script>document.getElementById('idRegCompany').style.display='block';</script>";
}

if(($act == "addRegisterCompany") && (!$error))
{	
	$SQL_insert = " 
	INSERT INTO `company`(`id_company`, `company_name`, `photo`, `overview`, `username`, `password`) 
					VALUES (NULL, '$company_name', '', '', '$username', '$password') ";
										
	$result = mysqli_query($con, $SQL_insert);

	$suc_login = "Successfully Registered";
	//echo $SQL_insert ;  exit;
	print "<script>document.getElementById('idSuccessRegisterCompany').style.display='block';</script>";
}
?>


<div id="idForgotUser" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
	<header class="w3-container w3-center"> 
		<span onclick="document.getElementById('idForgotUser').style.display='none'" 
		class="w3-button w3-display-topright w3-circle">&times;</span>
		<div class="w3-padding"></div>
		Forgot Password
	</header>
	<hr>
	<div class="w3-container">

<?PHP if($error) { ?>
	<div class="w3-content w3-container w3-white w3-text-red w3-round-large w3-border w3-border-red" style="max-width:600px">
		<div class="w3-padding">
		<div class="w3-large">Error!</div>
		<?PHP echo $error;?>
		</div>
	</div>
<?PHP } ?>

		<div class="w3-container w3-padding">
		<div class="w3-large"><b>Login Credential</b></div>
		<form action="" method="post">			
			
			<div class="w3-section" >
				Email *
				<input class="w3-input w3-border w3-round" type="email" name="email" value="" placeholder="Your registered email *" required>
			</div>			
			
			<div class="w3-section" >
				Mobile Phone *
				<input class="w3-input w3-border w3-round" type="tel" name="phone" pattern="^(\+?6?01)[01-46-9]-*[0-9]{7}$|^(\+?6?01)[1]-*[0-9]{8}$" placeholder="Registered Phone *   e.g: 60191234567" value="" required>
			</div>			

			<input name="act" type="hidden" value="resetPasswordUser">		
			<button type="submit" class="w3-button w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">Reset Password</button>
		</form> 
		</div>
		
		<div class="w3-center">Already registered? <a href="#" onclick="document.getElementById('idLogin').style.display='block';
		 document.getElementById('idForgotUser').style.display='none'" class="w3-text-red">Login Here</a></div>
    </div>
	
	<div class="w3-padding"></div>	

    </div>
</div>


<?PHP 
if($act == "resetPasswordUser")
{	
	$NewPassword = rand(10000,90000);
}
?>

<div id="idSuccessResetUser" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idSuccessResetUser').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		

		<div class="w3-padding"></div>
		<b class="w3-large">Success</b>
		  
		<hr class="w3-clear">
		
		Successfully Reset.<br>
		Your temporary password : <b><?PHP echo $NewPassword; ?></b>
		
		<div class="w3-padding-16"></div>
		
		<a href="#" onclick="document.getElementById('idSuccessResetUser').style.display='none'; document.getElementById('idLogin').style.display='block';" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">CONTINUE LOGIN <i class="fa fa-fw fa-lg fa-chevron-right"></i></a>

		</div>
	</div>
</div>

<div id="idErrorResetUser" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idErrorResetUser').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding w3-center">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Error</b>
			  
			<hr class="w3-clear">
			
			Email or Phone not found.
			
			<div class="w3-padding-16"></div>
			
			<!--<a onclick="document.getElementById('idErrorResetUser').style.display='none'; document.getElementById('idLogin').style.display='block';'" class="w3-button w3-block w3-padding-large w3-red w3-wide w3-margin-bottom w3-round">RETRY <i class="fa fa-fw fa-lg fa-history"></i></a>-->

		</form>
		</div>
	</div>
</div>

<?PHP
// Reset Password

if($act == "resetPasswordUser")
{	
	$found 	= numRows($con, "SELECT * FROM `user` WHERE `email` = '$email' AND `phone` = '$phone' ");
	if($found < 1) 
	{
		$error = "Email or Phone not found.";
		print "<script>document.getElementById('idForgotUser').style.display='none'; document.getElementById('idErrorResetUser').style.display='block';</script>";
	}
}

if(($act == "resetPasswordUser") && ($found > 0))
{	
	$SQL_update = " UPDATE `user` SET 
						`password` = '$NewPassword'
					WHERE `email` = '$email' AND `phone` = '$phone'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$successReset = "Successfully Reset";
	print "<script>document.getElementById('idForgotUser').style.display='none'; document.getElementById('idSuccessResetUser').style.display='block';</script>";
}
?>