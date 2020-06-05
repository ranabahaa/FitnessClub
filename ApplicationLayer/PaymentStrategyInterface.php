<?php 

//this to implement different payment strategies
	interface PaymentStrategy{
		function pay($member_id,$option);
    }
    
?>