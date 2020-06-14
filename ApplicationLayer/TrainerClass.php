<?php
    include_once('..//DataLayer/Database.php');
    class Trainer{
        
        function __construct(){
            $connectdb  = connectdb::getInstance();
            $conn = $connectdb->getConnection();

        }
     
        function TakeAttendance($trainerid,$memberid,$sessionid,$date,$count){
            $connectdb  = connectdb::getInstance();
            $conn = $connectdb->getConnection();
            if(!empty($trainerid) AND !empty($memberid) AND !empty($sessionid)){
              
                $sql ="INSERT INTO attendance(Trainer_id,Member_id,Session_id,Date,Count) VALUES ('$trainerid','$memberid','$sessionid','$date','$count')";
                $result= mysqli_query($conn,$sql);
                   $_SESSION['message']="welcome";
                    echo "attendance done successfuly";
                }
                else{
                    echo "Please fill the data";
                }
        }
    }  
    
    $trainerobject= new Trainer();
  
    if(isset($_POST['takeAttendancebtn'])){
        $trainerobject->TakeAttendance($_POST['trainerid'],$_POST['memberid'],$_POST['sessionid'],$_POST['date'],$_POST['count']);
    } 
    
?>        