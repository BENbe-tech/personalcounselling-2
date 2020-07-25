<?php
session_start();

require('../config.php');

$messageError = "";
//validating inputs
$regnumber = $_SESSION['registrationnumberc'];

if($regnumber != ""){
  $sq = "SELECT regnumberadvisor FROM relational WHERE regnumberclient='$regnumber' ";
  $result = $conn->query($sq);

  if($result->num_rows > 0){
	  $fetch = $result->fetch_assoc();
	  $regnumberadvisor = $fetch["regnumberadvisor"];

}

}

if(!empty($_GET['user'])){
  $user = $_GET['user'];
  
  $sq = "SELECT message,time FROM clientmessage WHERE regnumber='$user' ";
  $data = $conn->query($sq);
  if($data->num_rows > 0){
      
      while($fetch = $data->fetch_array(MYSQLI_ASSOC)){ 
          echo $fetch["message"] . ":".$fetch["time"] . "<br>";
      }
      
      $data -> free_result();  
  }
  
  }





if(!empty($_POST['send'])){


//validating message
if (empty($_POST["message"])) {
  $messageError = "please write a message";
  } 
  else {

  $message = test_input($_POST['message']);

}




if($messageError ==""){

  $sql = "INSERT INTO advisormessage(regnumber, message) VALUES('$regnumber','$message')";

  $connect =   $conn->query($sql);
}


$conn ->close();
}

//testing the inputs entered by the user

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data,ENT_QUOTES);
return $data; 
}

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script>
      function setActive(){
        var online = document.getElementsByClassName('onlineDiv');
        var input = document.getElementsByClassName('inputDiv');

        online[0].style.display = "block";
        input[0].style.display = "block";

      }
    </script>
    <style>
    body{
      margin: 0;
      background-color: #E0E0E0;
    }

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      width: 20%;
      background-color: #f1f1f1;
      position: fixed;
      height: 100%;
      overflow: auto;
    }

    li a {
      display: block;
      color: #000;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
    }

    li a.active {
      background-color: #448AFF;
      color: white;
    }

    li a:hover:not(.active) {
      background-color: #555;
      color: white;
    }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
  </head>

  <body>
    <ul>
    <li style="text-align:center;font-family: 'Poppins', sans-serif"><img src="https://img.icons8.com/cute-clipart/48/000000/chat.png"/><h3>My Advisors</h3></li>
    <li style="text-align:center;font-family: 'Poppins', sans-serif"><a href="client.php?user=<?php echo $regnumberadvisor;?>" ><?php echo $regnumberadvisor; ?></a></li>

    <li style="text-align:center;font-family: 'Poppins', sans-serif;margin-top:150%"><a href = "../logout.php">Log Out</a></li>
  </ul>

  <div
  class="onlineDiv"
  style="position:fixed;top:0;margin-left:500px;margin-left:300px;padding:1px 16px;width:100%;background-color:black;"
  >
    <p  style="text-align:center;font-family: 'Poppins', sans-serif;color:white">Your Advisor is Online</p>
  </div>

  <div
  style="position:fixed;left:0;bottom:0;width:100%;background:black;color:white;text-align:center;
  margin-left:100px;padding:1px 16px;"
  class="inputDiv"
  >
  <form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" name="message"     placeholder="Enter Message"
    style="width: 40%;
  padding: 12px 20px;
  margin-top: 20px;
  border: 3px solid #555;
  color: black;"
    >
    

      <input type = "submit" name = "send" value = "send"   style="background-color: #448AFF;
      border: none;
      color: white;
      margin-left: 150px;
      margin-top: 10px;
      padding: 16px 32px;
      text-decoration: none;
      cursor: pointer;">
 </form>
  </div>
  

  </body>
</html>