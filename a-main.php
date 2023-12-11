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
$tot_apply 		= numRows($con, "SELECT * FROM `apply`");
$tot_company 	= numRows($con, "SELECT * FROM `company`");
$tot_job 		= numRows($con, "SELECT * FROM `job`");
$tot_user 		= numRows($con, "SELECT * FROM `user`");
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

<?PHP include("menu-admin.php"); ?>


<div class="" >

	<div class="w3-padding-48"></div>


<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1400px">
		<div class="w3-padding">
		<div class="w3-xxxlarge"><b>WELCOME</b></div>
		<div class="w3-large"><b>Administrator Page</b></div>
			
			<div class="w3-padding-16"></div>
			
			<div class="w3-row w3-padding-24">
				<div class="w3-col m3 w3-container">
					<div class=" w3-card w3-red w3-round-xlarge w3-padding-16">
						<div class="w3-container w3-large">
							Application <i class="fa fa-user fa-lg w3-right"></i> 
							<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
							<h2 class="w3-center"><?PHP echo $tot_apply;?></h2>
						</div>
					</div>
				</div>
				
				<div class="w3-col m3 w3-container">
					<div class=" w3-card w3-dark-grey w3-round-xlarge w3-padding-16">
						<div class="w3-container w3-large">
							Companies <i class="fa fa-tasks fa-lg w3-right"></i> 
							<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
							<h2 class="w3-center"><?PHP echo $tot_company;?></h2>
						</div>
					</div>
				</div>
	
				<div class="w3-col m3 w3-container">
					<div class=" w3-card w3-dark-grey w3-round-xlarge w3-padding-16">
						<div class="w3-container w3-large">
							Jobs <i class="fa fa-list fa-lg w3-right"></i> 
							<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
							<h2 class="w3-center"><?PHP echo $tot_job;?></h2>
						</div>
					</div>
				</div>
				
				<div class="w3-col m3 w3-container">
					<div class=" w3-card w3-dark-grey w3-round-xlarge w3-padding-16">
						<div class="w3-container w3-large">
							Users <i class="fa fa-users fa-lg w3-right"></i> 
							<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
							<h2 class="w3-center"><?PHP echo $tot_user;?></h2>
						</div>
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
