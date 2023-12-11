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
$id_apply	= (isset($_REQUEST['id_apply'])) ? trim($_REQUEST['id_apply']) : '0';
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$success = "";

if($act == "Accept")
{
	$SQL_update = " UPDATE `apply` SET `status` = 'Accept' WHERE `id_apply` =  '$id_apply' ";
	$result = mysqli_query($con, $SQL_update);
	
	$success = "Successfully Accept";
}

if($act == "Reject")
{
	$SQL_update = " UPDATE `apply` SET `status` = 'Reject' WHERE `id_apply` =  '$id_apply' ";
	$result = mysqli_query($con, $SQL_update);
	
	$success = "Successfully Reject";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `apply` WHERE `id_apply` =  '$id_apply' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='a-apply.php';</script>";
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

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-apply.php?page=apply"); }
?>	

<div class="" >

	<div class="w3-padding-48"></div>

	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>APPLICATION</b></span><br>
	</div>


<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
		
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>	
					<th>Job Title / Company</th>
					<th>User</th>
					<th>Status</th>
					<th>Date Apply</th>
					<th>Date Update</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `apply`,`job`,`company`,`user` WHERE apply.id_job=job.id_job AND job.id_company = company.id_company AND apply.id_user = user.id_user";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_job	= $data["id_job"];
				$id_apply	= $data["id_apply"];
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>			
				<td><b><?PHP echo $data["job_title"] ;?></b><br><?PHP echo $data["company_name"] ;?></td>
				<td>
				<?PHP echo $data["name"] ;?>
				<a target="_BLANK" href="upload/<?PHP echo $data["resume"] ;?>" class="w3-blue w3-tag w3-padding-small"><i class="fa fa-fw fa-download fa-lg"></i> Resume</a>
				</td>
				<td><?PHP echo $data["status"] ;?></td>
				<td><?PHP echo $data["created_date"] ;?></td>
				<td><?PHP echo $data["modified_date"] ;?></td>
				<td>
				<a href="?act=Accept&id_apply=<?PHP echo $id_apply;?>" title="Accept" class="w3-green w3-tag w3-padding-small">Accept</a>
				<a href="?act=Reject&id_apply=<?PHP echo $id_apply;?>" title="Reject" class="w3-red w3-tag w3-padding-small">Reject</a>
				<a title="Delete" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
				</td>
			</tr>

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
			
			<input type="hidden" name="id_apply" value="<?PHP echo $data["id_apply"];?>" >
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

<div class="w3-padding-16"></div>
	
</div>


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
