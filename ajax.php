<?php

$server_name="localhost";
$username="root";
$password="";
$database_name="cognifront";

$conn=mysqli_connect($server_name,$username,$password,$database_name);



if(isset($_POST['Artist_Email']))
{
    $sql_query= "SELECT * FROM gyausers WHERE email='".$_POST['Artist_Email']."'";
    $result=mysqli_query($conn,$sql_query);
        
      echo  mysqli_num_rows($result);
        
}
if(isset($_POST['Artist_Mobile']))
{
    $sql_query= "SELECT * FROM gyausers WHERE mobile='".$_POST['Artist_Mobile']."'";
    $result=mysqli_query($conn,$sql_query);
        
      echo  mysqli_num_rows($result);
        
}


mysqli_close($conn);

?>
