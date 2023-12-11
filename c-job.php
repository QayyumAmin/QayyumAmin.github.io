<?PHP
session_start();

include("database.php");
if( !verifyCompany($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_company		= $_SESSION['id_company'];

$id_job 		= (isset($_REQUEST['id_job'])) ? trim($_REQUEST['id_job']) : '0';
$act 			= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$location		= (isset($_POST['location'])) ? trim($_POST['location']) : '';
$location_address= (isset($_POST['location_address'])) ? trim($_POST['location_address']) : '';
$location_map	= (isset($_POST['location_map'])) ? trim($_POST['location_map']) : '';
$job_title		= (isset($_POST['job_title'])) ? trim($_POST['job_title']) : '';
$salary			= (isset($_POST['salary'])) ? trim($_POST['salary']) : '';
$job_description= (isset($_POST['job_description'])) ? trim($_POST['job_description']) : '';
$career_level	= (isset($_POST['career_level'])) ? trim($_POST['career_level']) : '';
$qualification	= (isset($_POST['qualification'])) ? trim($_POST['qualification']) : '';
$year_experience= (isset($_POST['year_experience'])) ? trim($_POST['year_experience']) : '';
$job_type		= (isset($_POST['job_type'])) ? trim($_POST['job_type']) : '';
$job_specialization	= (isset($_POST['job_specialization'])) ? trim($_POST['job_specialization']) : '';

$job_title		=	mysqli_real_escape_string($con, $job_title);
$qualification	=	mysqli_real_escape_string($con, $qualification);
$job_description=	mysqli_real_escape_string($con, $job_description);

$success = "";

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `job`(`id_job`, `id_company`, `location`, `location_address`, `location_map`, `job_title`, `salary`, `job_description`, `career_level`, `qualification`, `year_experience`, `job_type`, `job_specialization`, `created_date`) 
	VALUES (NULL, '$id_company', '$location', '$location_address', '$location_map', '$job_title', '$salary', '$job_description', '$career_level', '$qualification', '$year_experience', '$job_type', '$job_specialization', NOW() )";		
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Add";

	//print "<script>self.location='c-package.php';</script>";
}

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`job`
	SET
		`location` = '$location',
		`location_address` = '$location_address',
		`location_map` = '$location_map',
		`job_title` = '$job_title',
		`salary` = '$salary',
		`job_description` = '$job_description',
		`career_level` = '$career_level',
		`qualification` = '$qualification',
		`year_experience` = '$year_experience',
		`job_type` = '$job_type',
		`job_specialization` = '$job_specialization'
	WHERE `id_job` =  '$id_job'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Update'); self.location='c-job.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `apply` WHERE `id_job` =  '$id_job' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$SQL_delete = " DELETE FROM `job` WHERE `id_job` =  '$id_job' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='c-job.php';</script>";
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

<?PHP include("menu-company.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "c-job.php?page=job"); }
?>	

<div class="" >

	<div class="w3-padding-48"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>JOB LIST</b></span><br>
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
					<th>Company</th>
					<th>Job Title</th>
					<th>Location</th>
					<th>Salary</th>
					<th>Career Level</th>
					<th>Qualification </th>
					<th>Job Type</th>
					<th>Specializations </th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `job`,`company` WHERE job.id_company = company.id_company AND job.id_company = $id_company";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_job= $data["id_job"];
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>				
				<td><?PHP echo $data["company_name"] ;?></td>
				<td><?PHP echo $data["job_title"] ;?></td>
				<td><?PHP echo $data["location"] ;?></td>
				<td><?PHP echo $data["salary"] ;?></td>
				<td><?PHP echo $data["career_level"] ;?></td>
				<td><?PHP echo $data["qualification"] ;?></td>
				<td><?PHP echo $data["job_type"] ;?></td>
				<td><?PHP echo substrwords($data["job_specialization"], 1000) ;?></td>
				<td>
				<a href="c-job-edit.php?id_job=<?PHP echo $id_job;?>" class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>
				<!--<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>-->
				
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
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Update Job</b>
			<hr>
			
				<div class="w3-section" >
					<label>Job Title *</label>
					<input class="w3-input w3-border w3-round" type="text" name="job_title" value="<?PHP echo $data["job_title"]; ?>" required>
				</div>
				
				<div class="w3-section" >
					<label>Job Location *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location" value="<?PHP echo $data["location"]; ?>" placeholder="Melaka" required>
				</div>
				
				<div class="w3-section" >
					<label>Location Address *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location_address" value="<?PHP echo $data["location_address"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >
					<label>Location Map *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location_map" value="<?PHP echo $data["location_map"]; ?>" placeholder="Location that found in google map. e.g: Mahkota Parade" required>
				</div>
				
				<div class="w3-section" >
					<label>Salary *</label>
					<input class="w3-input w3-border w3-round" type="text" name="salary" value="<?PHP echo $data["salary"]; ?>" placeholder="RM 1,700 - RM 2,380" required>
				</div>

				<div class="w3-section" >
					<label>Job Description *</label>
					<textarea class="w3-input w3-border w3-round" name="job_description" id="makeMeSummernote" rows="5" required><?PHP echo $data["job_description"]; ?></textarea>
				</div>
				
				<div class="w3-section" >
					<label>Career Level *</label>
					<input class="w3-input w3-border w3-round" type="text" name="career_level" value="<?PHP echo $data["career_level"]; ?>" placeholder="Manager" required>
				</div>
				
				<div class="w3-section" >
					<label>Qualification *</label>
					<input class="w3-input w3-border w3-round" type="text" name="qualification" value="<?PHP echo $data["qualification"]; ?>" placeholder="Diploma, Advanced/Higher/Graduate" required>
				</div>
				
				<div class="w3-section" >
					<label>Years of Experience *</label>
					<input class="w3-input w3-border w3-round" type="text" name="year_experience" value="<?PHP echo $data["year_experience"]; ?>" placeholder="1 year" required>
				</div>
				
				<div class="w3-section" >
					<label>Job Type *</label>
					<select class="w3-input w3-border w3-round" name="job_type" required>
						<option value="Full-Time" <?PHP if($data["job_type"] == "Full-Time") echo "selected";?> >Full-Time</option>
						<option value="Part-Time" <?PHP if($data["job_type"] == "Part-Time") echo "selected";?> >Part-Time</option>
					</select>
				</div>
				
				<div class="w3-section" >
					<label>Job Specializations *</label>
					<input class="w3-input w3-border w3-round" type="text" name="job_specialization" value="<?PHP echo $data["job_specialization"]; ?>" placeholder="Hotel/Restaurant, Food/Beverage/Restaurant" required>
				</div>
			  
			<hr class="w3-clear">
			<input type="hidden" name="id_job" value="<?PHP echo $data["id_job"];?>" >
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
			
			<input type="hidden" name="id_job" value="<?PHP echo $data["id_job"];?>" >
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
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Add Job</b>
			<hr>
				<div class="w3-section" >
					<label>Job Title *</label>
					<input class="w3-input w3-border w3-round" type="text" name="job_title" value="" placeholder="e.g. Assistant Restaurant Manager" maxlength="100" required>
				</div>
				
				<div class="w3-section" >
					<label>Job Location *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location" value="" placeholder="e.g. Melaka" required>
				</div>
				
				<div class="w3-section" >
					<label>Location Address *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location_address" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >
					<label>Location Map *</label>
					<input class="w3-input w3-border w3-round" type="text" name="location_map" value="" placeholder="Location that found in google map. e.g: Mahkota Parade" required>
				</div>
				
				<div class="w3-section" >
					<label>Salary *</label>
					<input class="w3-input w3-border w3-round" type="text" name="salary" value="" placeholder="e.g. RM 1,700 - RM 2,380" required>
				</div>

				<div class="w3-section" >
					<label>Job Description *</label>
					<textarea class="w3-input w3-border w3-round" name="job_description" id="makeMeSummernote2" rows="5" required></textarea>
				</div>
				
				<div class="w3-section" >
					<label>Career Level *</label>
					<input class="w3-input w3-border w3-round" type="text" name="career_level" value="" placeholder="e.g. Manager" required>
				</div>
				
				<div class="w3-section" >
					<label>Qualification *</label>
					<input class="w3-input w3-border w3-round" type="text" name="qualification" value="" placeholder="e.g. Diploma, Advanced/Higher/Graduate" required>
				</div>
				
				<div class="w3-section" >
					<label>Years of Experience *</label>
					<input class="w3-input w3-border w3-round" type="text" name="year_experience" value="" placeholder="e.g. 1 year" required>
				</div>
				
				<div class="w3-section" >
					<label>Job Type *</label>
					<select class="w3-input w3-border w3-round" name="job_type" required>
						<option value="Internship" >Internship</option>
						<option value="Full-Time" >Full-Time</option>
						<option value="Part-Time" >Part-Time</option>
					</select>					
				</div>
				
				<div class="w3-section" >
					<label>Job Specializations *</label>
					<input class="w3-input w3-border w3-round" type="text" name="job_specialization" value="" placeholder="e.g. Hotel/Restaurant, Food/Beverage/Restaurant" required>
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
	$('#makeMeSummernote,#makeMeSummernote2').summernote({
		height:200,
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
