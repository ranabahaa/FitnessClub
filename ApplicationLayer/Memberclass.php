<?php 

//include ('..//ApplicationLayer/Observer.php');
include('..//ApplicationLayer/CashStrategyClass.php');
include('..//ApplicationLayer/PayPalStrategyClass.php');
include('..//ApplicationLayer/CreditCardStrategyClass.php');
include('../DataLayer/Database.php');

class Member{
  private $session_id;
  private $trainer_id;
  private $member_id;
   public $id ;

 
 public function __constructor($sid,$tid,$mid){
   	$this->session_id=$sid;//the data submitted when a button is pressed
   	$this->trainer_id=$tid;
   	$this->member_id=$mid;
   }
   //----------------------------------------------------------------------------------------------------------
	public function getMemberList(){
		$object= new Database();
		$object->selectAll('member');
	} 
  //----------------------------------------------------------------------------------------------------------
  public function bookSession($values){
            $object= new Database();
            $object->insert('booking_sessions',$values);  

  	}
  
//----------------------------------------------------------------------------------------------------------
  public function bookPackage($value){
  	$obj= new Database();
     $obj->insert('booking_packages',$value);
  	
  }
  //----------------------------------------------------------------------------------------------------------
  public function DisplayPackages(){
  
   $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();

//Retrive the id of avaiable trainers for that session
  $query="SELECT DISTINCT Package_id ,sessionsDetails FROM packages ";
  $result = mysqli_query($conn,$query);
  // $arrays=mysqli_fetch_all($result,MYSQLI_ASSOC);
    
   return $result;
}
//----------------------------------------------------------------------------------------------------------
//Display to the user ALL sessions in database
public function DisplaySession(){
  
   $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();

//Retrive the id of avaiable trainers for that session
  $query="SELECT DISTINCT Session_id ,Session_name FROM sessions ";
  $result = mysqli_query($conn,$query);
  // $arrays=mysqli_fetch_all($result,MYSQLI_ASSOC);
    
   return $result;
}

  //----------------------------------------------------------------------------------------------------------
  public function selectSession($sessionId){//when the user enters the session id
  
   $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();
//Retrive the id of avaiable trainers for that session
  $query="SELECT TrainerID FROM sessions WHERE Session_id = $sessionId ";
  $result = mysqli_query($conn,$query);
  $arrays=mysqli_fetch_all($result,MYSQLI_ASSOC);
   return $arrays;
}//Returns the Assoc array containing the TrainerId
//----------------------------------------------------------------------------------------------------------
  public function selectPackage(){//when the user enters the package id
  
   $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();

//Retrive the id of avaiable trainers for that session
  $query="SELECT TrainerID FROM sessions";//kol asm2 el Trainers ely mawgodeeen
  $result = mysqli_query($conn,$query);
   $arrays=mysqli_fetch_all($result,MYSQLI_ASSOC);

   return $arrays;
}//Returns the Assoc array containing the TrainerId
//----------------------------------------------------------------------------------------------------------
//Retrive the aviable trainers for that session
public function selectTrainer($trainername){
     $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();
   $qu="SELECT Trainer_id FROM trainer WHERE Trainer_name = '$trainername' ";
  
   $results = mysqli_query($conn,$qu);
   $arrays=mysqli_fetch_assoc($results);
   $trainerId=$arrays['Trainer_id'];

   $id=$_SESSION['id'];//Member's Id from login

   $IdOfSession=$_SESSION['sessionId'];

   $valuesToInsert="$IdOfSession,$id,$trainerId";//Id of the member

    $member=new Member();
    $member->bookSession($valuesToInsert);
  
  // return $arrays;

  }//Returns the TrainerId of the selected Trainer by the user to be stored in the database
//----------------------------------------------------------------------------------------------------------
 //Retrive All the Trainers 
public function selectTrainer2($trainername){
     $connectdb  = connectdb::getInstance();
   $conn = $connectdb->getConnection();
   $qu="SELECT Trainer_id FROM trainer WHERE Trainer_name = '$trainername' ";
  
   $results = mysqli_query($conn,$qu);
   $arrays=mysqli_fetch_assoc($results);
   $trainerId=$arrays['Trainer_id'];

   $id=$_SESSION['id'];//Member's Id from login

   $IdOfPackage=$_SESSION['packageId'];

   $valuesToInsert="$id,$IdOfPackage,$trainerId";//Id of the Package As session varibale

    $member=new Member();
    $member->bookPackage($valuesToInsert);
  
  // return $arrays;

  }//Returns the TrainerId of the selected Trainer by the user to be stored in the database
//----------------------------------------------------------------------------------------------------------
       
        //THE NOTIFICATION METHOD: UNCOMPLETE
        public function update()
	    {
		   echo "i am observer $this->id"."<br>";
	    }
//----------------------------------------------------------------------------------------------------------
		public function writeReview($trainer_name,$feedback){
        
         $connectdb  = connectdb::getInstance();
         $conn = $connectdb->getConnection();
         $qu="SELECT Trainer_id FROM trainer WHERE Trainer_name = '$trainer_name' ";
         $results = mysqli_query($conn,$qu);
         $arrays=mysqli_fetch_assoc($results);
         $trainer_id=$arrays['Trainer_id'];
         $member_id=$_SESSION['id'];
         $member=new Member();
         $db = new DataBase();
 	     $TableName="review(Member_id,Trainer_id,Review)";
 	     $Values = "$member_id,$trainer_id,'$feedback'";
 	     $db->insert($TableName,$Values);
        }
//----------------------------------------------------------------------------------------------------------
		
public function pay($member_id,$option){
    
    if ($option == "cash"){
				$wayOne = new CashStrategy();
				$wayOne-> pay($member_id,$option);
    }

if ($option == "paypal"){
				$wayThree = new PayPalStrategy();
				$wayThree -> pay($member_id,$option);
            }
if ($option == "visa"){
				$wayTwo = new CreditCardStrategy();
				$wayTwo -> pay($member_id,$option);
          } 
    
  }

}

 ?>