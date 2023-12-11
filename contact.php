<?PHP
session_start();
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


<div class="" >

	<div class="w3-padding-48"></div>


<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container " style="max-width:1400px">
		<div class="w3-padding">
		<div class="w3-xxxlarge"><b>CONTACT US</b></div>
	
			
			<div class="w3-row">
				<div class="w3-col m4 w3-padding w3-center">
					<div class="w3-large w3-padding w3-padding-16">
						<div class=""><img src="images/logo.png" ></div>						
					</div>

				</div>
				<div class="w3-col m8 w3-padding">
					<div class="w3-large w3-borderx w3-border-red w3-padding w3-padding-16 w3-round-xlarge" style="border: 5px solid">
						<div class="w3-row w3-margin-left">
							<div class="w3-col m1">
								<i class="fa fa-envelope-o fa-2x"></i>
							</div>
							<div class="w3-col m4">
								<a href="mailto:JobBoard@gmail.com" class="w3-text-red">JobBoard@gmail.com</a>
							</div>
							<div class="w3-col m1">&nbsp;</div>
							<div class="w3-col m1">
								
							</div>
							<div class="w3-col m4">
								
							</div>							
						</div>
						<div class="w3-padding-16"></div>
						<div class="w3-row w3-margin-left">
							<div class="w3-col m1">
								<i class="fa fa-whatsapp fa-2x"></i>
							</div>
							<div class="w3-col m4">
								WhatsApp
							</div>
						</div>
						<div class="w3-row w3-margin-left">
							<div class="w3-col m1">
								&nbsp;
							</div>
							<div class="w3-col m4">
								<a target="_blank" class="w3-text-red" href="https://wa.me/60189637294">+60 18-963 7294</a><br>
							</div>
							<div class="w3-col m1">&nbsp;</div>
							<div class="w3-col m1">&nbsp;</div>
							<div class="w3-col m4">
								Working hours:<br>
								8.30am – 5.30pm<br>
								(Monday – Friday)
							</div>							
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
