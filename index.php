<?php
// Start the session
session_start();
require("db.php");
?>

<?php
if (isset($_POST['login'])) 
{
   $query = mysqli_query($conn,"select * from users where email='".$_POST["email"]."' AND password='".$_POST["password"]."'");
    $rows = mysqli_num_rows($query); 
    if($rows==1) {
   // Initializing Session
    $row=mysqli_fetch_assoc($query);
   if($row["confirmed"]==1){
    $_SESSION["user_id"]=$row["sno"];
    $_SESSION["dname"]=$row["dname"];
    $_SESSION["email"]=$row["email"];
        
        header('Location: '.$_SERVER['PHP_SELF']);
die;
   }else{echo "<script type=\"text/javascript\">window.alert('You need to verify your account');window.location.href = './login.php';</script>";}
} 
else
{
echo "<script type=\"text/javascript\">window.alert('You have entered either wrong Username or Password.');window.location.href = './login.php';</script>";
}
}
?>

<!DOCTYPE html>
<html>
<title>Bytepoch</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-site-verification" content="KTg1xAdCStDfTozd1r5oVRMQ5O6-pCHsoMCXgEHTqr4" />
    <meta name="keywords" content="bytepoch,programming,questions,answers,java,c,javascript,php,mysql">
    <link rel="stylesheet" href="rohit2.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="rohit.css">
     
 <link href="Images/favicon.png" rel="icon" type="image/png" />
    <style >a{text-decoration: none}</style>

<body style="background:#f2f2f2;"> 
     

 <?php
require("header.php");
?>
    
    <div class="w3-content w3-white" style=";max-width:1075px">
        
 <?php
        if(!isset($_SESSION["user_id"])){
echo '<div class="w3-container " style="background:#f2f2f2;margin-left:15px;margin-right:15px;">
    
<span onclick="this.parentElement.style.display='."'"."none"."'".'" class="w3-closebtn">&times;</span>
 
  <div class="w3-row w3-container w3-padding-4" >
      <div class="w3-col m4 w3-container">
          <p> Bytepoch is the questions and answers site for the enthusiastic programmers just like you.</p>
          <p> <a href="signup.php" class="btn w3-round">Sign up</a></p>
      </div>
      <div class="w3-rest w3-container">
          <h5 style="font-weight:bold"> Here is how it works:</h5>
      
    <p class="w3-col m4 w3-padding-4 w3-container">Anybody who has a knack for programming can ask question.</p>
      
      
    <p class="w3-col m4 w3-padding-4 w3-container">Anybody can answer any question. </p>     
        
         
    <p class="w3-col m4 w3-padding-4 w3-container">The best answers are voted up and rise to the top.</p>      
     
          
      </div>
     
      
    </div>
</div>';}?>
    <div class="w3-row ">
    <div class="w3-twothird w3-container">
       
      <p><?php

    $sql = "SELECT questions.sno as q_sno, questions.title,  SUBSTRING_INDEX(description, ' ', 29) as des, users.sno as u_sno, users.dname FROM questions,users where  questions.user_id = users.sno order by q_sno desc";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
        echo "<h4 ><b>Questions</b></h4><hr>";
    while($row = mysqli_fetch_assoc($result)) {
       
     
       $row["title"]= htmlspecialchars($row["title"]);
       
       
            
      echo '<a style="color:teal" href="answers.php?id='.$row["q_sno"].'">'.$row["title"].'</a><br>';
       echo '<p style="font-size:13px">'.htmlspecialchars($row["des"]).'...</p>';
        echo "<div style='text-align:right;color:gray'>asked by</div>";
        
         echo "<div style='text-align:right;color:rgb(70,189,196)'>".'<a href="profile.php?id='.$row["u_sno"].'">'.htmlspecialchars($row["dname"]).'</a>'."</div>";
       
         echo "<hr>";
    }
} else {
    echo "0 results";
}
    mysqli_close($conn);
    ?></p>
    </div>
    <div class="w3-third w3-container">
      <p class="w3-border vl6  w3-container" style="color:grey"><i>
          <q> Debugging is twice as hard as writing the code in the first place. Therefore, if you write the code as cleverly as possible, you are, by definition, not smart enough to debug it. </q><br><br><span class="w3-right">- Brian Kernighan</span></i>
        </p>
        <p class="w3-border vl6  w3-container" style="color:grey"><i><q> If debugging is the process of removing software bugs, then programming must be the process of putting them in. </q> <br><br><span class="w3-right">- Edsger Dijkstra</span></i></p>
    </div>
  </div>
   
      
      
         
    </div>
  <?php
require("footer.php");
?>

</body>
</html>