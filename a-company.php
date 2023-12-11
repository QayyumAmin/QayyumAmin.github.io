<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_company = (isset($_REQUEST['id_company'])) ? trim($_REQUEST['id_company']) : '0';
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$company_name=(isset($_POST['company_name'])) ? trim($_POST['company_name']) : '';
$overview	= (isset($_POST['overview'])) ? trim($_POST['overview']) : '';

$company_name=	mysqli_real_escape_string($con, $company_name);
$overview	=	mysqli_real_escape_string($con, $overview);

$success = "";

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `company`(`id_company`, `company_name`, `photo`, `overview`) 
				VALUES (NULL, '$company_name', '', '$overview')";		
										
	$result = mysqli_query($con, $SQL_insert);
	
	$id_company = mysqli_insert_id($con);
	
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
	// -------- End Photo -----------------
	
	$success = "Successfully Add";
	
	//print "<script>self.location='a-package.php';</script>";
}
if($act == "edit")
{	
	$SQL_update = " UPDATE
						`company`
					SET
						`company_name` = '$company_name',
						`overview` = '$overview'
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
	// -------- End Photo -----------------
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Update'); self.location='a-company.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `job` WHERE `id_company` =  '$id_company' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$SQL_delete = " DELETE FROM `apply` WHERE `id_company` =  '$id_company' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$SQL_delete = " DELETE FROM `company` WHERE `id_company` =  '$id_company' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='a-company.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<title>JobBoard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

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

<body class="">

<?PHP include("menu-admin.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-company.php?page=company"); }
?>	

<div class="" >

	<div class="w3-padding-48"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>COMPANY LIST</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
	  
		<a onclick="document.getElementById('add01').style.display='block'; " class="w3-margin-bottom w3-right w3-button w3-blue w3-round "><i class="fa fa-fw fa-lg fa-plus"></i> Add</a>
		
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Logo</th>
					<th>Company Name</th>
					<th>Overview</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `company` ";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$photo	= $data["photo"];
				if(!$photo) $photo = "noimage.jpg";
				$id_company= $data["id_company"];
				$overview = $data["overview"];
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><img src="upload/<?PHP echo $photo; ?>" class="w3-round-large w3-image" alt="image" style="width:100%;max-width:100px"></td>
				<td><?PHP echo $data["company_name"] ;?></td>
				<td><?PHP if($overview <> "") { echo substrwords($overview, 1000); }?></td>
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>
				
				<a title="Delete" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
				</td>
			</tr>
			
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:800px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" enctype="multipart/form-data" >
			<div class="w3-padding"></div>
			<b class="w3-large">Update Company</b>
			<hr>

				<div class="w3-section" >
					<?PHP if($data["photo"] =="") { ?>
					<label >Logo</label>
					<div class="custom-file">
						<input type="file" class="w3-input w3-border w3-round" name="photo" id="photo" accept=".jpeg, .jpg,.png,.gif">
					</div>
					<p></p>
					<?PHP } ?>
										
					<?PHP if($data["photo"] <>"") { ?>
					<label >Logo</label><br>
					<a class="w3-tag w3-green w3-round" target="_BLANK" href="upload/<?PHP echo $data["photo"]; ?>"><small>View</small></a>

					<a class="w3-tag w3-red w3-round" href="photo-del.php?id_company=<?PHP echo $data["id_company"];?>"><small>Remove</small></a>
					
					<?PHP } else { ?><span class="w3-tag w3-round"> <small>None</small></span><?PHP } ?>
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
			  
				<div class="w3-section" >
					<label>Company Name *</label>
					<input class="w3-input w3-border w3-round" type="text" name="company_name" value="<?PHP echo $data["company_name"]; ?>" required>
				</div>

				<div class="w3-section" >
					<label>Description *</label>
					<textarea class="w3-input w3-border w3-round" name="overview" id="makeMeSummernote" rows="5" required><?PHP echo $data["overview"]; ?></textarea>
				</div>

			  
			<hr class="w3-clear">
			<input type="hidden" name="id_company" value="<?PHP echo $data["id_company"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round">SAVE CHANGES</button>

		</form>
		</div>
	</div>
<div class="w3-padding-24"></div>
</div>

<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Confirmation</b>
			  
			<hr class="w3-clear">			
			Are you sure to delete this record ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_company" value="<?PHP echo $data["id_company"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, CONFIRM</button>
		</form>
		</div>
	</div>
</div>				
			<?PHP } ?>
			</tbody>
		</table>
		</div>
		</div>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
</div>



<div id="add01" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:800px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('add01').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
	  
      <div class="w3-container w3-padding">
		
		<form action="" method="post" enctype="multipart/form-data" >
			<div class="w3-padding"></div>
			<b class="w3-large">Add Company</b>
			<hr>
			  
				
				<div class="w3-section" >
					<label>Logo *</label>
					<input class="w3-input w3-border w3-round" type="file" name="photo" required >
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
				
				<div class="w3-section" >
					<label>Company Name *</label>
					<input class="w3-input w3-border w3-round" type="text" name="company_name"  required>
				</div>

				<div class="w3-section" >
					<label>Decsription *</label>
					<textarea class="w3-input w3-border w3-round" name="overview" id="makeMeSummernote2" rows="5"  required></textarea>
				</div>	
			  
			  <hr class="w3-clear">
			  
			  <div class="w3-section" >
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round">SUBMIT</button>
			  </div>
			</div>  
		</form> 
         
      </div>
<div class="w3-padding-24"></div>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<!--<script src="assets/demo/datatables-demo.js"></script>-->


<script>
$(document).ready(function() {

  
	$('#dataTable').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
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
