<?php
ob_start ('ob_gzhandler');
session_start ();

require "common-code-shared.php";
require "dbconfig.php";
require "ajax.php";

$g_signupStage = 0;
if (isset($_POST['submitBasicInfo']))
	processBasicInfo ();
else if (isset($_POST['submitDetailedInfo']))
	processDetailedInfo ();

function showBasicInfoInputs ()
{
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"> </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

   
<script>

$(document).ready(function(){

 $("#ArtistEmail").blur(function(){
var ArtistEmail=$(this).val();

$.ajax({
                      url:"ajax.php",
                      method:"POST",
                    data:{Artist_Email:ArtistEmail},
                  
                   success:function(dt){
					   if(dt !='0')
					   {
						$('#availability').html("<span class='text-danger'>Username Not Available</span>");
						$('#Submit').attr("disabled",true);
					   }
					   else{
						$('#availability').html("<span class='text-success'>Username  Available</span>");
						$('#Submit').attr("disabled",false);
					   }
                }
            });
 });
});
</script>


<script>

$(document).ready(function(){
 $("#ArtistMobile").blur(function(){
var ArtistMobile=$(this).val();

$.ajax({
                      url:"ajax.php",
                      method:"POST",
                    data:{Artist_Mobile:ArtistMobile},
                  
                   success:function(dt){
					   if(dt !='0')
					   {
						$('#mobile').html("<span class='text-danger'>mobile No Already Exist</span>");
						$('#Submit').attr("disabled",true);
					   }
					   else{
						$('#mobile').html("<span class='text-success'>Mobile No  Available</span>");
						$('#Submit').attr("disabled",false);
					   }
                }
            });
 });
});
</script>
</head>
<body>
	<div class="panel panel-default" style="padding:20px;">
		<h3 class="text-center">
			Artist Sign-up
		</h3>

		<div class="d-block">
			<form name="RegForm" method="post" onsubmit="return data_validate();">

				<div class="form-group">
					<label for="ArtistName">Your Full Name</label>
					<input type="text" id="ArtistName" name="ArtistName" placeholder="Enter name" class="form-control" required/>
				</div>
				<div class="form-group">
					<label for="ArtistEmail">Email ID</label>
					<input type="email" id="ArtistEmail" name="ArtistEmail" placeholder="Enter email id" class="form-control" />
					<span id="availability"> </span>
				</div>
				<div class="form-group">
					<label for="ArtistMobile">Mobile Number</label>
					<input type="text" id="ArtistMobile" name="ArtistMobile" placeholder="Enter mobile number" class="form-control" />
					<span id="mobile" class="text-danger"></span>
				</div>
				<div class="form-group">
                    <label for="DOB"> Date Of Birth </label><br>
                    <input  id="DOB" class="form-control" placeholder="Enter DOB" name="DOB" />
                    <script>
                        $('#DOB').datepicker({
                            uiLibrary: 'bootstrap4'
							
                        });
                    </script>
					</div>
				<div class="form-group">
					<label for="ArtistEmail">Password</label>
					<input type="password" id="ArtistPass" name="ArtistPass" placeholder="Enter the Password" class="form-control" />
					<span id="passw" class="text-danger font-weight-bold"></span>
				</div>
				<div class="form-group">
					<label for="ArtistEmail">Confirm Password</label>
					<input type="password" id="ArtistConPass" name="ArtistConPass" placeholder="Reenter the Password" class="form-control" />
					 <span id="con_pswd" class="text-danger font-weight-bold"></span>
				</div>

				<input type="submit" id="Submit" name="submitBasicInfo" class="btn btn-success" value="Sign Up" />

			</form>
		</div>
	</div>
	</body>
</html>
	<?php
}

function processBasicInfo ()
{
	global $g_signupStage;
	
	$con = connect_to_database ("cognifront");
	//$_POST = sanitize ($con, $_POST);

	$name = $_POST['ArtistName'];
	$email = $_POST['ArtistEmail'];
	$password = $_POST['ArtistPass'];
    
	$options = [ 
	    'cost' => 12, 
	]; 
  
    $encrypt_pass = password_hash ($password, PASSWORD_BCRYPT, $options); //password_hash() function in php to encrypt the password. Using PASSWORD_BCRYPT Alogorithm
	$mobile = $_POST['ArtistMobile'];
	$obfus = generateRandomString (32,false);

    

	




    $q = "insert into gyausers(usertype,obfus,name,email,pwd,mobile,regdate)values('artist','$obfus','$name','$email','$encrypt_pass','$mobile','now()')";
	mysqli_query ($con, $q);
	if (mysqli_affected_rows ($con) > 0)
	{
		$_SESSION["obfus"] = $obfus;
		$_SESSION["name"] = $name;
		$_SESSION["currentuserid"] = mysqli_insert_id ($con);
		$_SESSION["usertype"] = "artist";
		$g_signupStage = 1;
	}
	else
	{
		echo '<script>alert("error occur 1")</script>';
	}
    disconnect_from_database ($con);
}

function showDetailedInfoInputs ()
{
	?>
	<div class="panel panel-default" style="padding:20px;">
		<h3 class="text-center">
			Complete Your Profile
		</h3>

		<div class="d-block">
			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="ArtistDisplayName">Your Display Name <small><span style="font-weight:normal;color:#888;">(for instance Band's Name)</span></small></label>
					<input type="text" id="ArtistDisplayName" name="ArtistDisplayName" placeholder="Enter display name" class="form-control" />
				</div>
				<div class="form-group">
					<label for="ArtistBio">Biography <small><span style="font-weight:normal;color:#888;">(this is displayed on your profile)</span></small></label>
					<textarea id="ArtistBio" name="ArtistBio" placeholder="Write your biography here ..." class="form-control" rows="6"></textarea>
				</div>
				<div class="form-group">
					<label for="ArtistGender">Gender</label>
					<select id="ArtistGender" name="ArtistGender" class="form-control">
						<option value="male" selected>Male</option>
						<option value="female">Female</option>
					</select>
				</div>
				<div class="form-group">
					<label>Where are you based?</label>
				</div>
				<div class="form-group">
					<label for="ArtistCity">City</label>
					<input type="text" id="ArtistCity" name="ArtistCity" placeholder="Enter city" class="form-control" />
				</div>
				<div class="form-group">
					<label for="ArtistState">State</label>
					<input type="text" id="ArtistState" name="ArtistState" placeholder="Enter state" class="form-control" />
				</div>
				<div class="form-group">
					<label for="ArtistCountry">Country</label>
					<input type="text" id="ArtistCountry" name="ArtistCountry" placeholder="Enter country" class="form-control" />
				</div>

				<input type="number" id="ArtistFees" name="ArtistFees" placeholder="Enter fees" class="form-control" />
				<br>
				<div class="form-group">
					<label for="file">Your Profile Picture</label>
					<input type="file" name="ArtistPicture" id="file" class="form-control" accept="image/*" />
				</div>

				
			<input type="submit" name="submitDetailedInfo" class="btn btn-success" value="DONE" />
			</form>
		</div>
	</div>
	<?php
}

function processDetailedInfo ()
{
	global $g_signupStage;
	
	$con = connect_to_database ("cognifront");
	//$_POST = sanitize ($con, $_POST);
    print_r($_POST);
	$displayname = $_POST['ArtistDisplayName'];
	$DOB=$_POST['DOB'];
	$bio = $_POST['ArtistBio'];
	$city = $_POST['ArtistCity'];
	$state = $_POST['ArtistState'];
	$fees = $_POST['ArtistFees'];
	$country = $_POST['ArtistCountry'];
	$gender = $_POST['ArtistGender'];
	
	$target_dir = "uploads/";
	$path_info = pathinfo($_FILES["ArtistPicture"]["name"]);
	$photo = $target_dir . generateRandomString (32,false) . '.' . strtolower($path_info['extension']);
	$allowedextensions = array('png','jpg','jpeg');

	$strErrMsg = "";
	if (in_array(strtolower($path_info['extension']),$allowedextensions))
	{
		move_uploaded_file($_FILES["ArtistPicture"]["tmp_name"], $photo);
		
	    $q = "update gyausers set city='$city',state='$state',country='$country',gender='$gender' where obfus='".$_SESSION["obfus"]."'";
		if (mysqli_query ($con, $q))
		{
			$q = "select id from gyausers where obfus='".$_SESSION["obfus"]."'";
			$rs = mysqli_query ($con, $q);
			if (mysqli_num_rows ($rs) > 0)
			
			{
				$row = mysqli_fetch_assoc ($rs);

				$id = $row["id"];
				$q = "insert into artists_profile (artistid,displayname,DOB,bio,fees,profilepicture) values ('$id','$displayname','$DOB','$bio','$fees','$photo')";
				mysqli_query ($con, $q);
				if (mysqli_affected_rows ($con) > 0)
					$g_signupStage = 2;
				else
					$strErrMsg = "artist info not saved";			
			}
			else
				$strErrMsg = "artist profile not found";
		}
		else
		   $strErrMsg = "Profile picture extension should be either jpeg,png or jpg";
    }
	else
		$strErrMsg = "internal error";

	disconnect_from_database ($con);
}

function showFinalUI ()
{
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Thank you!</h4>
		</div>
		<div class="panel-body">
			Excellent! Now you are signed up successfully. Continue browsing for other artists, events ...
		</div>
	</div>
	<?php
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
		<title>Artist Sign-up</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
	
		<script>
		function data_validate ()
		{
			var password = document.forms["RegForm"]["ArtistPass"]; 
			var conpass = document.forms["RegForm"]["ArtistConPass"]; 
			var phone = document.forms["RegForm"]["ArtistMobile"];
			if (phone.value.length>10 || phone.value.length<10)
			{ 
				document.getElementById('mobile').innerHTML = "**Mobile no length must be atleast 10 digits";  
				return false; 
			}

			if (password.value.length < 8 || password.value.length>15)
			{
				document.getElementById('passw').innerHTML = "**Password length must be 8 characters to 15 characters and it should contain 1 digit and special symbol";
				return false;  
			} 

			if (password.value != conpass.value)
			{
				document.getElementById('con_pswd').innerHTML="**Password don't match";
				return false;
			}    
		} 
		</script>
	</head>
	<body>
		<div class="wrapper">
			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">
				
					<!-- main right col -->
					<div class="column col-sm-10 col-xs-11" id="main">
				  
						<div class="padding">
							<div class="full col-sm-9">
								<!-- content -->
								<div class="row">
									<!-- main col left -->
									<div class="col-sm-5">
										<?php
										//print_r ($_POST);
										switch ($g_signupStage)
										{
											case 0 : showBasicInfoInputs(); break;
											case 1 : showDetailedInfoInputs(); break;
											case 2 : showFinalUI(); break;
										}
										
										?>
									</div>
									<!-- main col right -->
									<div class="col-sm-7">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4>How does it work?</h4>
											</div>
											<div class="panel-body">Whoa! We are glad that you asked that question. It's simple. If you are an artist, you register here for free. You post your photos, event videos, publicize your portfolio - all for free. You can also specify your charges of events. The visitors and buyers come to the site. They can get in touch with you. And book your craft / show. They pay on the site. We transfer payment to you.
												
												<br/>
												<br/> If you are a buyer, you can browse all artists, and book their performances as per your requirement. You pay online. You can message artists and communicate with them.
											
											</div>
										</div>
										<div class="well">
											<form class="form">
												<h4>Receive our newsletter</h4>
												<div class="input-group text-center">
													<input class="form-control input-lg" placeholder="Enter your email address" type="text" />
													<span class="input-group-btn">
														<button class="btn btn-lg btn-primary" type="button">Subscribe</button>
													</span>
												</div>
											</form>
										</div>
									
									</div>
								</div>
								<!--/row-->
								
							</div>
							<!-- /col-9 -->
						</div>
						<!-- /padding -->
					</div>
					<!-- /main -->
				</div>
			</div>
		</div>
		<!--post modal-->
		<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
Update Status



					
									
							
					</div>
					<div class="modal-body">
						<form class="form center-block">
							<div class="form-group">
								<textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div>
							<button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Post</button>
							<ul class="pull-left list-inline">
								<li>
									<a href="">
										<i class="glyphicon glyphicon-upload"></i>
									</a>
								</li>
								<li>
									<a href="">
										<i class="glyphicon glyphicon-camera"></i>
									</a>
								</li>
								<li>
									<a href="">
										<i class="glyphicon glyphicon-map-marker"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>