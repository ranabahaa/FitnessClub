<?php 
include('..//ApplicationLayer/PaymentStrategyInterface.php');
	class CashStrategy implements PaymentStrategy{


	function pay($member_id,$option){
         
     $connectdb  = connectdb::getInstance();
         $conn = $connectdb->getConnection();
         $query="SELECT Member_Fname ,Member_Lname ,Member_email ,Member_password ,MobileNumber FROM member WHERE Member_id = '$member_id'";
         $result = mysqli_query($conn,$query);
         $arrays=mysqli_fetch_assoc($result);
         $memberPay[0]=$arrays['Member_Fname'];
         $memberPay[1]=$arrays['Member_Lname'];
         $memberPay[2]=$arrays['Member_email'];
         $memberPay[3]=$arrays['Member_password'];
         $memberPay[4]=$arrays['MobileNumber'];
         $memberPay[5]= 'Cash';
         $db = new DataBase(); 
   
    $member1 =  array(' Member_Fname ' => "'$memberPay[0]'",' Member_Lname '=>" '$memberPay[1]' ",' Member_email '=>" '$memberPay[2] '",'Member_password '=>" '$memberPay[3]' ",' MobileNumber '=> " '$memberPay[4]'",' Payment_Method '=>" '$memberPay[5]' ");
		
		Database::update("member",$member1,'Member_id',$member_id);
}
  }
    
?>