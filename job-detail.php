<?PHP
session_start();
include("database.php");
?>
<?PHP
$id_user 	= (isset($_SESSION['id_user'])) ? trim($_SESSION['id_user']) : '0';
$id_job 	= (isset($_REQUEST['id_job'])) ? trim($_REQUEST['id_job']) : '0';
$id_company	= (isset($_REQUEST['id_company'])) ? trim($_REQUEST['id_company']) : '0';
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$success = "";

if($act == "apply")
{	
	$SQL_insert = " 
	INSERT INTO `apply`(`id_apply`, `id_job`, `id_company`, `id_user`, `status`, `created_date`, `modified_date`) 
			VALUES (NULL, '$id_job', '$id_company', '$id_user', 'Pending', NOW(), '')";		
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Apply";	
	//echo $SQL_insert; exit;
	//print "<script>self.location='apply.php';</script>";
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
if($success) { Notify("success", $success, "apply.php?page=apply"); }
?>	


<?PHP
$SQL_list = "SELECT * FROM `job`,`company` WHERE job.id_company = company.id_company AND job.id_job = $id_job";
$result = mysqli_query($con, $SQL_list) ;
$data	= mysqli_fetch_array($result);
$photo	= $data["photo"];
if(!$photo) $photo = "noimage.jpg";
?>

<div class="" >

	<div class="w3-padding-64"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1400px">
		<div class="w3-padding">

			<div class="w3-row">
				<div class="w3-col m8 w3-padding">
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
						<div><b><?PHP echo $data["job_title"]; ?></b></div>
						<b><?PHP echo $data["company_name"]; ?></b><br>
						<?PHP echo $data["location"]; ?><br>
						<?PHP echo $data["salary"]; ?><br>
						Posted on <?PHP echo $data["created_date"]; ?>
					</div>
					<div class="w3-padding"></div>
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
						<div class="w3-xlarge"><b>Job Description</b></div>
						<?PHP echo $data["job_description"]; ?>
					</div>
					<div class="w3-padding"></div>
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
						<div class="w3-row">
							<div class="w3-col m6">
							<b>Career Level:</b><br>
							<?PHP echo $data["career_level"]; ?><br>
							<br>
							<b>Years of Experience:</b><br>
							<?PHP echo $data["year_experience"]; ?><br>
							<br>
							<b>Job Type:</b><br>
							<?PHP echo $data["job_type"]; ?>
							</div>
							<div class="w3-col m6">
							<b>Qualification:</b><br>
							<?PHP echo $data["qualification"]; ?>
							<br>
							<br>
							<b>Job Specializations:</b><br>
							<?PHP echo $data["job_specialization"]; ?>
							</div>
						</div>
					</div>
					
					<div class="w3-padding"></div>
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
						<div class="w3-xlarge"><b>Company Overview</b></div>
						<?PHP echo $data["overview"]; ?>
					</div>

				</div>
				
				
				<div class="w3-col m4 w3-padding w3-center">
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 5px solid; ">
						<div class="w3-center"><img src="upload/<?PHP echo $photo; ?>" style="max-height:200px; max-width:300px"></div>
						<div class="w3-center w3-text-red"><b><?PHP echo $data["company_name"]; ?></b></div>
						<?PHP echo $data["job_title"]; ?>
						
						<div class="w3-padding-16"></div>
						<div class="w3-small w3-right"><?PHP echo $data["location"]; ?></div>
						<div class="w3-padding-16"></div>
						
						
						<div class="w3-xlarge w3-border w3-border-red  w3-red w3-center">
							<b><?PHP echo $data["salary"]; ?></b>
						</div>
					</div>
					
					
					<div class="w3-padding-small"></div>
					<?PHP if(isset($_SESSION["email"])) { ?>
					<a href="?act=apply&id_job=<?PHP echo $id_job;?>&id_company=<?PHP echo $data["id_company"];?>" class="w3-button w3-large w3-red w3-round-large"><b>APPLY NOW</b></a>
					<?PHP } else { ?>
					<a href="#" disabled class="w3-disabled w3-button w3-large w3-red w3-round-large"><b>LOGIN TO APPLY</b></a>
					<?PHP } ?>
					
					<div class="w3-padding-16"></div>
					
					<div class="w3-center w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
						<div class="w3-xlarge"><b>Location</b></div>
						<?PHP echo $data["location_address"]; ?>
					</div>
					
					<div class="w3-padding-16"></div>
					
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 3px solid">
					<iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?php echo $data["location_map"]; ?>&output=embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
					
				</div>

			</div>
			
		
		</div>
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
