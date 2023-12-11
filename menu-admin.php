<?PHP 
require_once("database.php");
$page = (isset($_GET['page'])) ? trim($_GET['page']) : '';	
?>
<!-- Navbar (sit on top) -->
<div class="w3-top">
	<div class="w3-bar w3-dark-grey w3-text-white w3-large w3-padding-16 w3-padding" id="myNavbar">

		&nbsp;<a href="a-main.php" class="w3-bar-item"><img src="images/logo.png" height="60px"></a>

		<!-- Right-sided navbar links -->
		<div class="w3-right w3-hide-small">  
			<a href="a-apply.php?page=apply" class="w3-bar-item w3-button <?PHP if($page=="apply") echo "w3-text-red";?>"><b>Application</b></a>
			<a href="a-company.php?page=company" class="w3-bar-item w3-button <?PHP if($page=="company") echo "w3-text-red";?>"><b>Companies</b></a>
			<a href="a-job.php?page=job" class="w3-bar-item w3-button <?PHP if($page=="job") echo "w3-text-red";?>"><b>Jobs</b></a>
			<a href="a-user.php?page=user" class="w3-bar-item w3-button <?PHP if($page=="user") echo "w3-text-red";?>"><b>Users</b></a>
			<a href="logout.php" class="w3-bar-item w3-button"><b>Logout</b></a>	
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
		
	<a href="a-apply.php?page=apply" onclick="w3_close()" class="w3-bar-item w3-button">Application</a>
	<a href="a-company.php?page=company" onclick="w3_close()" class="w3-bar-item w3-button">Companies</a>
	<a href="a-job.php?page=job" onclick="w3_close()" class="w3-bar-item w3-button">Jobs</a>
	<a href="a-user.php?page=user" onclick="w3_close()" class="w3-bar-item w3-button">Users</a>
	<a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
</nav>