<!DOCTYPE html>
<html lang="en">
<?php

$conn=new mysqli('localhost','root','','appointment_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
date_default_timezone_set('Asia/Calcutta'); 
$date1 = date("Y-m-d H:i:s");
session_start();
$current_user=$_SESSION['current_stud_users'];

if(!$current_user){
	header("Location:../login/login.php");
}
if(isset($_POST['save'])){
	$checkbox = $_POST['check'];
	$checkboxes = $_POST['checks'];
	for($i=0;$i<count($checkbox);$i++){
	$update_id = $checkbox[$i];
    $app_no=$checkboxes[$i];	
	mysqli_query($conn,"update appointments set feedback='".$update_id."' WHERE appointment_no='".$app_no."'");
	
}
}

$sql = "SELECT * FROM appointments where date<'$date1' and student_id='$current_user ' and (status='Approved' )";
$result = mysqli_query($conn,$sql);

?>




	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Appointment Management System</title>
		<meta name="keywords" content="Add keywords" />
		<meta name="author" content="_yourName_ for Codrops" />
		<link rel="shortcut icon" href="../favicon.ico"> 
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<style>
table {
  border-collapse: collapse;
 
}
th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
button{
	 background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  cursor: pointer;
	border-radius: 12px;
}
</style>
	<body>
		<div class="container">	
			<!-- Codrops top bar -->
			<div class="codrops-top clearfix">
				
			</div><!--/ Codrops top bar -->
			<header class="clearfix">
				<h1>Appointment Management System </h1>	
			</header>
			<div class="main">
			<div class="side">
					<nav class="dr-menu">
						<div class="dr-trigger"><span class="dr-icon dr-icon-menu"></span><a class="dr-label">Account</a></div>
						<ul>
							<li><a  href="index.php">Profile</a></li>
							<li><a  href="../make appointment/make_app.php">Make an Appointment</a></li>
							<li><a  href="upcoming.php">Upcoming</a></li>
							<li><a  href="history.php">Feedback </a></li>
							<li><a  href="change_pswd.php">Change password </a></li>
							<li><a  href="../logout.php">Logout</a></li>
						</ul>
					</nav>
				</div>
			<p>

<form method="post" action="">
<table cellpadding="15">
<thead>
<?php
$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
if(!$rows){
	echo"<H1>  Have not booked any appointments before</H1>";
}
else{
echo'
<tr>
    <th>SELECT</th>
	<th>STAFF NAME</th>
	
	
	<th>PURPOSE</th>
	
	<th>DATE</th>
	<th>FEEDBACK</th>
</tr>
</thead>';




foreach($conn-> query($sql) as $row){
$staff_name=$row["staff_id"];
	$names = "SELECT name FROM staff where staff_id='$staff_name'";
    $name_res = mysqli_query($conn,$names);
	$name_row = mysqli_fetch_array($name_res, MYSQLI_ASSOC);
echo'
<tr>';
if($row['feedback']==''){
	echo'
	
<td><input type="checkbox" id="checkItem" name="checks[]" value="'. $row["appointment_no"].'"></td>';}
else{
echo'	<td></td>';
}
echo'
	<td>'.  $name_row["name"].'</td>

	
	<td>'.  $row["purpose"].'</td>

	<td>'.  $row["date"] .'</td>';
	
	if($row['feedback']==''){
		


	echo'
	
	<td><form > <input type="text" id="checkItem" name="check[]" ></form></td>';}
	else{
		echo'<td>'.  $row["feedback"] .'</td>
	</tr>';}


}
echo'
</table><br><br>
<p align="center"><button type="submit" class="btn btn-success" name="save">Submit feedback</button></p>
</form>
';
}
?>





				</p>
				
			</div>
		</div><!-- /container -->
		<script src="js/ytmenu.js"></script>
	</body>
</html>
