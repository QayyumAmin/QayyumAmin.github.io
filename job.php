<?PHP
session_start();

$id_company	= (isset($_REQUEST['id_company'])) ? trim($_REQUEST['id_company']) : '0';
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

.footer {
  background-position: bottom;
  background-size: 100%;
  background-repeat: no-repeat;
  background-attachment:fixed;
  background-image: url(images/footer.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}

.w3-biru,.w3-hover-biru:hover{color:#fff!important;background-color:#08244c!important}
</style>

<body class="footer w3-white">

<?PHP include("menu.php"); ?>


<div class="" >

	<div class="w3-padding-48"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1400px">
		<div class="w3-padding">
		<div class="w3-xxxlarge"><b>JOBS</b></div>
		<div class="w3-large"><b>Find a job for you	</b></div>

			<div class="w3-padding-16"></div>
			
			<div class="w3-row">
				<?PHP
				$bil = 0;
				$SQL_list = "SELECT * FROM `job`,`company` WHERE job.id_company = company.id_company AND company.id_company = $id_company";
				$result = mysqli_query($con, $SQL_list) ;
				if(mysqli_num_rows($result) > 0) 
				{
					while ( $data	= mysqli_fetch_array($result) )
					{
						$bil++;
						$id_job= $data["id_job"];
						$photo	= $data["photo"];
						if(!$photo) $photo = "noimage.jpg";
				?>			
				<div class="w3-col m4 w3-padding w3-center">
					<a href="job-detail.php?id_job=<?PHP echo $id_job;?>">
					<div class="w3-white w3-large w3-text-red w3-hover-border-black w3-hover-text-red w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 5px solid; ">
						<div class="w3-center"><img src="upload/<?PHP echo $photo; ?>" style="max-height:200px; max-width:300px"></div>
						<div class="w3-center w3-text-black"><b><?PHP echo $data["company_name"]; ?></b></div>
						<a href="job-detail.php?id_job=<?PHP echo $id_job;?>" class="w3-hide-small"><?PHP echo $data["job_title"]; ?></a>
						
						<div class="w3-padding-16"></div>
						<div class="w3-small w3-right"><?PHP echo $data["location"]; ?></div>
						<div class="w3-padding-16"></div>
						
						<div class="w3-xlarge w3-border w3-border-red w3-red w3-center">
							<b><?PHP echo $data["salary"]; ?></b>
						</div>
						
					</div>
					
					</a>
				</div>
				<?PHP 
					} 
				} else echo "- Sorry. No result found -";
				?>
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
