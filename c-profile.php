<?PHP
session_start();

require_once("database.php");
if( !verifyCompany($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP 
$id_company	= $_SESSION['id_company'];

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$company_name=(isset($_POST['company_name'])) ? trim($_POST['company_name']) : '';
$overview	= (isset($_POST['overview'])) ? trim($_POST['overview']) : '';
$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$company_name=	mysqli_real_escape_string($con, $company_name);
$overview	=	mysqli_real_escape_string($con, $overview);

$success = "";

if($act == "edit") 
{
	$SQL_update = " UPDATE
						`company`
					SET
						`company_name` = '$company_name',
						`overview` = '$overview',
						`username` = '$username',
						`password` = '$password'
					WHERE `id_company` =  '$id_company'";
										
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
			 
			$query = "UPDATE `company` SET `photo`='$file_name' WHERE `id_company` = '$id_company'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	// -------- Photo -----------------
	
	$success = "Successfully Update";
}

if($act == "photo_del")
{
	$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `company` WHERE `id_company`= '$id_company'"));
	unlink("upload/" .$dat['photo']);
	$rst_d 	= mysqli_query( $con, "UPDATE `company` SET `photo`='' WHERE `id_company` = '$id_company' " );
	print "<script>self.location='c-profile.php';</script>";
}

$SQL_view 	= " SELECT * FROM `company` WHERE `id_company` =  '$id_company' ";
$result 	= mysqli_query($con, $SQL_view) or die("Error in query: ".$SQL_view."<br />".mysqli_error($con));
$data		= mysqli_fetch_array($result);
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

<!-- include summernote css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- include summernote js-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

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


<?PHP include("menu-company.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "c-profile.php"); }
?>	
<!-- Content -->

<div class="" >

	<div class="w3-padding-48"></div>



<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1000px">
	
	<div class="w3-xxxlarge"><b>PROFILE</b></div>
		<div class="w3-large"><b>Update your profile & password</b></div>
	
		
	<form action="" method="post" enctype="multipart/form-data" >
	<div class="w3-row">
	<div class="w3-col m7">
		<div class="w3-padding">
		
		<div class="w3-padding-16"></div>


			<div class="w3-section" >
				<label>Company Name *</label>
				<input class="w3-input w3-border w3-round" type="text" name="company_name" value="<?PHP echo $data["company_name"]; ?>" required>
			</div>

			<div class="w3-section" >
				<label>Description *</label>
				<textarea class="w3-input w3-border w3-round" name="overview" id="makeMeSummernote" rows="5" required><?PHP echo $data["overview"]; ?></textarea>
			</div>
			
			<div class="w3-section" >
				Username
				<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $data["username"];?>"  placeholder="Email *" required>
			</div>
			
			<div class="w3-section">
				Password
				<input class="w3-input w3-border w3-round" type="password" name="password" id="password" value="<?PHP echo $data["password"];?>"  maxlength="20" placeholder="Password *" required>
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

			<input name="id_company" type="hidden" value="<?PHP echo $id_company;?>">
			<input name="act" type="hidden" value="edit">
			<button type="submit" class="w3-button w3-padding-large w3-green w3-wide w3-margin-bottom w3-round">Save Changes</button>
		 
		
		</div>
		
	</div>
	<div class="w3-col m5">
		<div class="w3-padding">
		<div class="w3-padding-32"></div>
		
		<div class="w3-border w3-round-large">
		<div class="w3-section w3-center" >
			
			<img src="upload/<?PHP echo $photo; ?>" class="w3-image" alt="image" style="width:100%;max-width:200px">
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
		

	
		</div>
	</div>
	
	</div> 
	<!-- row -->
	</form> 
		
		
    </div>
</div>

<div class="w3-padding-16"></div>
	
</div>


<!-- Script -->
<script type="text/javascript">
	/*$('#makeMeSummernote,#makeMeSummernote2').summernote({
		height:200,
	});*/
</script>

<script type="text/javascript">
	$('#makeMeSummernote,#makeMeSummernote2').summernote({
	  toolbar: [
		// [groupName, [list of button]]
		['style', ['bold', 'italic', 'underline', 'clear']],
		['font', ['strikethrough', 'superscript', 'subscript']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['height', ['height']]
	  ],
	  height:300,
	});
</script>	
 
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
