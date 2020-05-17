<?php 

include ('Observer.php');


//include ('../DataLayer/Database.php');
//require('FpdfLibrary/fpdf.php');
include('PDF.php');

class Member implements Observer 
{
	public $id ;
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function update()
	{
		echo "i am observer $this->id"."<br>";
	}




}
class Admin implements Subject
{
	 protected $observers = [];
	public $id;
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function addObserver( Observer $newObserver)
	{
		array_push($this->observers, $newObserver);
		echo "admin added Observer $newObserver->id"."<br>";
	}

	public function deleteObserver( Observer $removedObserver)
	{
		    $key = array_search($removedObserver, $this->observers);

		    unset($this->observers[$key]);
		   echo "admin deleted Observer $removedObserver->id"."<br>";


	}
	public function notify()
	{
		foreach ($this->observers as $observer) 
		{
			# code...	
			# code...
			$observer->update();
		}

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
		$package =  array('Package_duration' => $packageDetails[1],'Begining_date'=>$packageDetails[2],'End_date'=>$packageDetails[3],'Package_fee'=>$packageDetails[4],'Admin_id'=>$packageDetails[5] );
		Database::update("packages",$package,'Package_id',$packageId);
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
	$package  = array(20,20,20,20,20,1);
	$admin->updatePackage($package,10);*/

?>