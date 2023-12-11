<?PHP
session_start();

require_once("database.php");
if( !verifyUser($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP 
$id_user 	= (isset($_REQUEST['id_user'])) ? trim($_REQUEST['id_user']) : '';	
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$name 		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$gender 	= (isset($_POST['gender'])) ? trim($_POST['gender']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password 	= (isset($_POST['passwordx'])) ? trim($_POST['passwordx']) : '';

$success = "";

if($act == "edit") 
{
	$SQL_update = " UPDATE `user` SET 
						`name` = '$name',
						`phone` = '$phone',
						`gender` = '$gender',
						`email` = '$email',
						`password` = '$password'
					WHERE `id_user` =  '$id_user'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	// -------- Photo -----------------
	if(isset($_FILES['photo'])){		 
		  $file_name = $_FILES['photo']['name'];
		  $file_size = $_FILES['photo']['size'];
		  $file_tmp = $_FILES['photo']['tmp_name'];
		  $file_type = $_FILES['photo']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"upload/".$file_name);
			 
			$query = "UPDATE `user` SET `photo`='$file_name' WHERE `id_user` = '$id_user'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	// -------- Photo -----------------
	
	// -------- Resume -----------------
	if(isset($_FILES['resume'])){
		 
		  $file_name = $_FILES['resume']['name'];
		  $file_size = $_FILES['resume']['size'];
		  $file_tmp = $_FILES['resume']['tmp_name'];
		  $file_type = $_FILES['resume']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"upload/".$file_name);
			
			$query = "UPDATE `user` SET `resume`='$file_name' WHERE `id_user` =  '$id_user'";		
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	// -------- End Photo -----------------
	
	$success = "Successfully Update";
}

if($act == "photo_del")
{
	$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `user` WHERE `id_user`= '$id_user'"));
	unlink("upload/" .$dat['photo']);
	$rst_d 	= mysqli_query( $con, "UPDATE `user` SET `photo`='' WHERE `id_user` = '$id_user' " );
	print "<script>self.location='profile.php';</script>";
}

$SQL_view 	= " SELECT * FROM `user` WHERE `email` =  '{$_SESSION['email']}' ";
$result 	= mysqli_query($con, $SQL_view) or die("Error in query: ".$SQL_view."<br />".mysqli_error($con));
$data		= mysqli_fetch_array($result);
$id_user	= $data["id_user"];
$photo		= $data["photo"];
if(!$photo) $photo = "noimage.png";
?>
<!DOCTYPE html>
<html>
<title>JobBoard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
a { text-decoration : none ;}
body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-attachment:fixed;
  background-image: url(images/banner.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}

.w3-biru,.w3-hover-biru:hover{color:#fff!important;background-color:#08244c!important}
</style>

<body class="w3-white">


<?PHP include("menu.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "profile.php"); }
?>	
<!-- Content -->

<div class="" >

	<div class="w3-padding-48"></div>



<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1000px">
	
	<div class="w3-xxxlarge"><b>PROFILE</b></div>
		<div class="w3-large"><b>Update your profile & resume</b></div>
	
		
	<form action="" method="post" enctype="multipart/form-data" >
	<div class="w3-row">
	<div class="w3-col m7">
		<div class="w3-padding">
		
		<div class="w3-padding-16"></div>


		
			
			
				
			<div class="w3-section" >				
				Full Name
				<input class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"];?>" placeholder="Name *" required>
			</div>
			
			<div class="w3-section" >
				Contact No
				<input class="w3-input w3-border w3-round" type="tel" name="phone" value="<?PHP echo $data["phone"];?>"  pattern="^(\+?6?01)[01-46-9]-*[0-9]{7}$|^(\+?6?01)[1]-*[0-9]{8}$" placeholder="Mobile Phone * " value="<?PHP echo $phone;?>" required>
				<small>e.g: 60191234567</small>
			</div>
			
			<div class="w3-section" >
				Gender
				<select class="w3-select w3-border w3-round" name="gender"  required>
					<option value="">- Select Gender -</option>
					<option value="Male" <?PHP if($data["gender"] == "Male") echo "selected";?>>Male</option>
					<option value="Female" <?PHP if($data["gender"] == "Female") echo "selected";?>>Female</option>
				</select>
			</div>
			
			<div class="w3-section" >
				Email
				<input class="w3-input w3-border w3-round" type="email" name="email" value="<?PHP echo $data["email"];?>"  placeholder="Email *" required>
			</div>
			
			<div class="w3-section">
				Password
				<input class="w3-input w3-border w3-round" type="password" name="passwordx" id="password" value="<?PHP echo $data["password"];?>"  maxlength="20" placeholder="Password *" required>
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

			<input name="id_user" type="hidden" value="<?PHP echo $id_user;?>">
			<input name="act" type="hidden" value="edit">
			<button type="submit" class="w3-button w3-padding-large w3-green w3-wide w3-margin-bottom w3-round">Save Changes</button>
		 
		
		</div>
		
	</div>
	<div class="w3-col m5">
		<div class="w3-padding">
		<div class="w3-padding-32"></div>
		
		<div class="w3-border w3-round-large">
		<div class="w3-section w3-center" >
			
			<img src="upload/<?PHP echo $photo; ?>" class="w3-circle w3-image" alt="image" style="width:100%;max-width:200px">
			<?PHP if($data["photo"] <>"") { ?>
			<br>
			<a class="w3-tag w3-red w3-round w3-small" href="?act=photo_del"><small>Remove</small></a>
			<?PHP }  ?>
		</div>
		
		<div class="w3-section" >
			<?PHP if($data["photo"] =="") { ?>
			<div class="custom-file">
				<input type="file" class="w3-input w3-border w3-round-large" name="photo" id="photo" accept=".jpeg, .jpg,.png,.gif">
				<small>  only JPEG, JPG, PNG or GIF allowed </small>
			</div>
			<?PHP } ?>
		</div>
		</div>
		
		
		<div class="w3-section" >
				<?PHP if($data["resume"] =="") { ?>
				<label >Resume</label>
				<div class="custom-file">
					<input type="file" class="w3-input w3-border w3-round" name="resume" id="resume" accept=".pdf">
				</div>
				<p></p>
				<?PHP } ?>
									
				<?PHP if($data["resume"] <>"") { ?>
				<label >Resume</label><br>
				<div class="w3-input w3-border w3-round" >
				<a class="w3-tag w3-green w3-round" target="_BLANK" href="upload/<?PHP echo $data["resume"]; ?>"><small>View</small></a>

				<a class="w3-tag w3-red w3-round" href="resume-del.php?id_user=<?PHP echo $data["id_user"];?>"><small>Remove</small></a>
				</div>
				<?PHP } else { ?><span class="w3-tag w3-round"> <small>None</small></span><?PHP } ?>
				<small>  only PDF allowed </small>
			</div>
	
		</div>
	</div>
	
	</div> 
	<!-- row -->
	</form> 
		
		
    </div>
</div>

<div class="w3-padding-16"></div>
	
</div>

	
 
<script>

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>
