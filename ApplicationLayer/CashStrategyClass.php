<?php 
include('../DataLayer/Database.php');
include('PaymentStrategyInterface.php');

	class CashStrategy implements PaymentStrategy{


	function pay($member_id,$option){
         
     $db = new DataBase(); 
        
	$connectdb  = connectdb::getInstance();
    $conn = $connectdb->getConnection();
    $qu="SELECT Member_Fname, Member_Lname, Member_email, Member_password, MobileNumber FROM member WHERE Member_id = $member_id ";
  
    $results = mysqli_query($conn,$qu);
    $arrays=mysqli_fetch_assoc($results);
    $fname=$arrays['Member_Fname'];
    $lname=$arrays['Member_Lname'];
    $email=$arrays['Member_email'];
    $pass=$arrays['Member_password'];
    $mobile=$arrays['MobileNumber'];
    $member  = array('$fname','$lname','$email','$pass','$mobile','Cash');
	$db -> update("member",$member,' Member_id ',$memberId);
}
  }
    
?>