<?php 

include ('Observer.php');
include ('PersonClass.php');


//include ('../DataLayer/Database.php');
//require('FpdfLibrary/fpdf.php');
include('PDF.php');

/*class Member implements Observer 
{
	public $id ;
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function update()
	{
		$messege = "i have been Notified from Admin ";
	}
}

*/



class Admin implements Subject
{
	public   $observers = [];
	public $id;
	public $notificationId = 1;
	public function __construct($id)
	{
		$this->id = $id;

	}
	public  function addObserver( Observer $newObserver)
	{
		//array_push(Admin::$observers, $newObserver->member_id);
		$observer = array('Member_Id' => $newObserver->member_id,'Admin_Id'=>$this->id);
		//echo "admin added Observer $newObserver->id"."<br>";
		print_r($observer);

		Database::insert("Observers",implode( ',',$observer));
	}


	public  function notify($sessionName)
	{

		$observers=DataBase::selectAll("Observers");
		foreach ($observers as $observer) 
		{
			# code...	
			# code...
			$observer = new member($observer['MemberId']);

			$array = array('Notification_Id'=>'NULL','Admin_Id'=> $this->id,'Member_Id' => $observer->member_id,'Notification'=>" ' Check our New Session $sessionName '");
		//	echo "Observers id ";
		//	echo $observer->member_id;
					$array = implode(",", $array);


			Database::insert("notification",$array);
		//	$this->notificationId++;
		}

	}
		public  function deleteObserver( Observer $removedObserver)
	{
		    $key = array_search($removedObserver,Admin::$observers);

		    unset(Admin::$observers[$key]);
		 //  echo "admin deleted Observer $removedObserver->id"."<br>";


	}

	public function addPakcage($packageDetails)
	{
		$package;
		$package = implode(",", $packageDetails);
		echo "<br>$package <br>";
		if(Database::insert("packages",$package))
		{
			echo "Done";
		}
		else
		{
			echo "ERROR";
		}

	}


	public function updatePackage($packageDetails,$packageId)
	{
		$package =  array(' Package_duration ' => $packageDetails[0],' Beginning_date '=>"'$packageDetails[1]'",' End_date '=>"'$packageDetails[2]'",' Package_fee '=>$packageDetails[3],' Admin_id '=>$packageDetails[4] );
		Database::update("packages",$package,'Package_id',$packageId);
		//echo "'$packageDetails[1]'";	
	}

	public function updateSession($sessionDetails,$sessionId)
	{
		$session =  array(' Session_name ' => " '$sessionDetails[0]' ",' Session_cost '=>$sessionDetails[1],' discount '=>$sessionDetails[2],' Start_time '=>" '$sessionDetails[3]' ",' End_time '=>"'$sessionDetails[4]'",' Session_days '=>"'$sessionDetails[5]'",' Session_goal '=>"'$sessionDetails[6]'",' Trainer_name '=>" '$sessionDetails[7]'" );
		Database::update("sessions",$session,'Session_id',$sessionId);
	}

		public function updateMember($memberDetails,$memberId)
	{
		$member =  array(' Member_Fname ' => "'$memberDetails[0]'",' Member_Lname '=>" '$memberDetails[1]' ",' Member_email '=>" '$memberDetails[2] '",'Member_password '=>" '$memberDetails[3]' ",' MobileNumber '=> " '$memberDetails[4]' ");
		//echo "mobile phone is $memberDetails[4]<br>";
		Database::update("member",$member,' Member_id ',$memberId);
	}

		public function updateTrainer($trainerDetails,$trainerId)
	{
		//you need '' surround string variable that's why " '' " is used
		$trainer =  array(' Trainer_Fname ' => "'$trainerDetails[0]'",' Trainer_Lname ' => " '$trainerDetails[1]' ", 'Trainer_email ' =>"'$trainerDetails[2]'" , 'Trainer_password '=> "'$trainerDetails[3]'",'Trainer_salary '=>$trainerDetails[4],'Hired_Date'=>" '$trainerDetails[5]' ",' Shifts ' => " '$trainerDetails[6] '");

		Database::update("trainer",$trainer,' Trainer_id ',$trainerId);
	}

	public function generatePdf()
	{
		$pdf = new pdf();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->headerTable();
		$pdf->viewTable();
		$pdf->Output();


	}
	
    	public function AddSession($SessionId,$SessionName,$SessionCost,$Discount,$StartTime,$EndTime,$SessionDays,$SessionGoal,$TrainerName)
 	{
 	   //connect DB
 	 $TableName="sessions(Session_id,Session_name,Session_cost,discount,Start_time,End_time,Session_days,Session_goal,Trainer_name)";
 	 $Values = "'$SessionId','$SessionName','$SessionCost','$Discount','$StartTime','$EndTime','$SessionDays','$SessionGoal','$TrainerName'"; 

 	 Database::insert($TableName,$Values);


 	/* $Db = new DataBase();   //connect DB
 	 $TableName="Sessions(Session_id,Session_name,Session_cost,discount,Start_time,End_time,Session_days,Session_goal,Trainer_name)";
 	 $Values = "'$SessionId','$SessionName','$SessionCost','$Discount','$StartTime','$EndTime','$SessionDays','$SessionGoal','$TrainerName'"; 
 	if( $Db -> insert($TableName,$Values))
 	{
 		echo" inserted";
 	}
 	else{
 		echo "error";
 	}
 	 */
 	}	


 	 function deleteMember($id)
	{
	   //$connectdb  = connectdb::getInstance();
       //$conn = $connectdb->getConnection();
       $tableName = 'member';
       $memberId = 'member_id';
       Database::deletefunction ($tableName,$memberId,$id) ;
	}
	 function addMember($fristName,$lastName,$emailAddress,$password,$memberId,$phoneNumber)
	{   

		$tableName = 'member';
		$values="'$memberId','$fristName','$lastName','$emailAddress','$password','$phoneNumber'";
	  // $arrayName = array('Member_Fname' => $fristName,'Member_Lname' => $lastName,'Member_email' => $emailAddress,'Member_password' => $password ,'Member_id' => $memberId,'MobileNumber' => $phoneNumber);

	Database::insert($tableName,$values);


	}
	function addPackage($packageId,$packageDuration,$beginingDate,$endDate,$packageFee,$adminId,$sessionsDetails)
	{
		$tableName = 'packages';
		$values="'$packageId','$packageDuration','$beginingDate','$endDate','$packageFee','$adminId' ,'$sessionsDetails' ";
		//$arr = $arrayName = array('Package_id' => $packageId,'Package_duration' => $packageDuration ,'Beginning_date' => $beginingDate ,'End_date' => $endDate ,'Package_fee' => $packageFree ,'Admin_id' => $adminId ,'sessionsDetails' => $sessionsDetails );

		Database::insert($tableName,$values);	
								 	
	}
		 function deletePackage($id)
	{
		$tableName = 'packages';
		$packageId = 'Package_id';
		
		 Database:: deletefunction ($tableName,$packageId,$id) ;

	}
	function upload_image($SessionId)
    {
      # code...
     // HABDT ATIIA 

  $db = new DataBase();
  $db->upload_Image($SessionId);     

    }
      public function ListSessions()
 	{
 		$Db = new DataBase(); 
 		return $Db ->  selectAll("sessions");
 	}

 	public function ViewSession($SId)
 	{
 		$Db = new DataBase(); 
 		return $Db->selectRecord("sessions","Session_id",$SId);
 	}

 	function display($SessionId){
 		$db = new Database();
 		$db->Display($SessionId);


 	}


 	 	public function AddTrainer($Id,$FirstName,$LastName,$Email,$Password,$Salary,$HiredDate,$Shift)
 	{
 	
 	 $Db = new DataBase();   //connect DB
 	 $TableName="trainer(Trainer_id,Trainer_Fname,Trainer_Lname,Trainer_email,Trainer_password,Trainer_salary,Hired_Date,Shifts)";
 	 $Values = "'$Id','$FirstName','$LastName','$Email','Password','$Salary','$HiredDate','$Shift'"; //new trainer data
 	 $Db -> insert($TableName,$Values);
 	 
 	}	
 		public function DeleteTrainer($Id)
 	{
 		$Db = new DataBase();
 		$Db->deletefunction("trainer","Trainer_id",$Id);

 	}
 		public function DeleteSession($SessionId)
 	{
 		$Db = new DataBase();
 		$Db->deletefunction("sessions"," Session_id ",$SessionId);

 	}
	public function ListPackages()
 	{
 		$Db = new DataBase(); 
 		return $Db ->  selectAll("packages");
 	
 	}


 	public function Search($Id)
 	{
 		$Db = new DataBase(); 
 		return $Db->selectRecord("trainer","Trainer_id",$Id);
 	}

 	public function ViewMemberAttendance($SessionId)
 	{
 		$Db = new DataBase(); 
 		//$TableName="MemberAttendance(Member_id,Trainer_id)";
 		return $Db->selectRecord("attendance","Session_id",$SessionId);

 	}
 	public function ViewPackage($PId)
 	{
 		$Db = new DataBase(); 
 		return $Db->selectRecord("packages","Package_id",$PId);
 	}

 	public function ViewMember($MId)
 	{
 		$Db = new DataBase(); 
 		return $Db->selectRecord("member","Member_id",$MId);
 	}

	
}

/*
	$admin = new Admin(10);
	 $member = new Member(1);
	
	 $member2 = new Member(2);
	
	 $member3 = new Member(3);
	 	//$admin->generatePdf();


	$admin->addObserver($member);

	$admin->addObserver($member2);

	$admin->addObserver($member3);

	$admin->notify();
	$admin->deleteObserver($member2);
	$admin->notify();
	*/
/*	$package  = array(10,10,10,10,10,1);
//	$admin->updatePackage($package,10);
	$member  = array('ahmed','mohamed','ahmed@20180026','2000','01000');
	$session  = array( 'updatedZomba',200,20,'11 pm updated','12 pm ',4,'spa updated','Mike tayson');
	$trainer  = array('ahmed','mohamed','ahmed@20180026','pass_',2000,'21-5-2020','from 10 to 10');

	$admin = new Admin(10);
	//$admin->updatePackage($package,10);
	//$admin->updateTrainer($trainer,13);
	$admin->updateSession($session,2);
	//$admin->updateMember($member,5);
*/
?>