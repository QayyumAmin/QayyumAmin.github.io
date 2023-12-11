<?PHP 
require_once("database.php");
include("login-pop.php");
$page = (isset($_GET['page'])) ? trim($_GET['page']) : '';	
?>
<!-- Navbar (sit on top) -->
<div class="w3-top">
	<div class="w3-bar w3-grey w3-text-white w3-large w3-padding-16 w3-padding" id="myNavbar">
 
		&nbsp;<a href="index.php" class="w3-bar-item1"><img src="images/logo.png" height="60px"></a>

		<!-- Right-sided navbar links -->
		<div class="w3-right w3-hide-small">  
			<!--<a href="job.php?page=job" class="w3-bar-item w3-button <?PHP if($page=="job") echo "w3-text-red";?>"><b>Jobs</b></a>-->
			<a href="company.php?page=company" class="w3-bar-item w3-button <?PHP if($page=="company") echo "w3-text-red";?>"><b>Companies</b></a>
			<a href="contact.php?page=contact" class="w3-bar-item w3-button <?PHP if($page=="contact") echo "w3-text-red";?>"><b>Contact</b></a>
			<?PHP if(!isset($_SESSION["email"])) { ?>
			<a href="#" onclick="document.getElementById('idLogin').style.display='block'" class="w3-bar-item w3-button"><i class="fa fa-user-circle fa-2x"></i></a>
			<?PHP } else { ?>
			<a href="apply.php?page=apply" class="w3-bar-item w3-button <?PHP if($page=="apply") echo "w3-text-red";?>"><b>Your Application</b></a>
			<a href="profile.php?page=profile" class="w3-bar-item w3-button <?PHP if($page=="profile") echo "w3-text-red";?>"><b>Profile / Resume</b></a>
			<a href="logout.php" class="w3-bar-item w3-button"><b><i class="fa fa-fw fa-power-off fa-lg"></i> Logout</b></a>
			<?PHP } ?>
		</div>
		<!-- Hide right-floated links on small screens and replace them with a menu icon -->

		<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
		  <i class="fa fa-bars"></i>
		</a>
	
	</div>
	<hr style="border-top: 5px solid #FF0000; margin: 0px 0 0px 0">
	
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-red w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
	<a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
	
	
	<!--<a href="job.php?page=job" onclick="w3_close()" class="w3-bar-item w3-button">Jobs</a>-->
	<a href="company.php?page=company" onclick="w3_close()" class="w3-bar-item w3-button">Companies</a>
	<a href="contact.php?page=contact" onclick="w3_close()" class="w3-bar-item w3-button">Contact</a>
</nav>