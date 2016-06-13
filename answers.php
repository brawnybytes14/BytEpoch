<?php
require("db.php");
?>

<?php
// Start the session
session_start();
if(!isset($_GET["id"]))
{
     echo "<script type=\"text/javascript\">window.location.href = './index.php';</script>";
      
}
else{
   $_GET["id"]=intval($_GET["id"]); 
}
?>
<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rohit2.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="rohit.css">
    <style >a{text-decoration: none}</style>
    <script src="bootstrap/scripts/jquery-2.1.4.min.js"></script>

    <script>
        
function showUser(unique,user_id,sid,what,value,no) {
   
    if(sid==0){alert("you must login to vote");return;}else{
        if(sid==user_id){alert("you can not vote your own post");return;}else{
            
        }
    }
     $.ajax({
          type: "GET",
          url: "getuser.php",
          data: "sid=" + sid + "&what=" + what + "&value=" + value + "&no=" + no,
          success: function(msg){
                    
 document.getElementById(unique).innerHTML=msg;
  return;
                   }
         
     });
}

</script>
    
<body style="background:#f2f2f2;"> 
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>


<?php
require("header.php");
?>
    
    <div class="w3-content w3-white" style="max-width:1075px">


    <div class="w3-row ">
    <div class="w3-twothird w3-container">
      <p><?php
 
$sql = "SELECT questions.title, questions.description, questions.user_id,questions.votes, users.dname FROM questions, users where questions.sno='".$_GET["id"]."' and users.sno=questions.user_id"; 
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result); 
if($rows==0)
{
      echo "<script type=\"text/javascript\">window.location.href = './index.php';</script>";   
}
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        $row["title"]= htmlspecialchars($row["title"]);
        echo "<title>".$row["title"]. " | "."Bytepoch"."</title>";
          echo '<h3><b><a style="text-decoration:none;color:rgba(13,98,92,0.7)" href="answers.php?id='.$_GET["id"].'">'.$row["title"].'</a></b></h3>';
        
      if(isset($_SESSION["user_id"])){$s=$_SESSION["user_id"];}else{$s=0;}
        echo "<hr>";
        $unique="'"."q".$_GET["id"]."'";
         echo '<div class="w3-row">';
        
        
        echo '<div class="w3-col  w3-center" style="color:gray;width:30px;"><form>
<label><input type="radio" style="display:none;" name='.$unique.' onclick="showUser('.$unique.','.$row["user_id"].','.$s.',1,1,'.$_GET["id"].');"><b  title="This is useful"style="cursor:pointer;font-size:30px">+</b></label>
<div id='.$unique.'>'.$row["votes"].'</div>
<label><input type="radio"style="display:none;" name='.$unique.' onclick="showUser('.$unique.','.$row["user_id"].','.$s.',1,0,'.$_GET["id"].');"><b  title="This is not useful"style="cursor:pointer;font-size:30px">-</b></label>

</form></div>
';
        
      
     echo "<div class='w3-rest ' style='margin-left:40px'><p style='white-space: pre-wrap;background:none;border:none;line-height:;font-family:verdana'>".htmlspecialchars($row["description"])."</p>";
        
        echo    ' 

<div class="fb-share-button" data-href="answers.php?id='.$_GET["id"].'" data-layout="button" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2F&amp;src=sdkpreparse"></a></div>';
        
        if(isset($_SESSION["user_id"])&&($row["user_id"]==$_SESSION["user_id"])||(isset($_SESSION["user_id"])&&$_SESSION["user_id"]==2)){
        
            echo '<a style="color:rgb(70,189,196);margin-left:20px" href="edit_question.php?qid='.$_GET["id"].'&id='.$row["user_id"].'">edit</a> ';  
        }
   
        
        echo '</div></div>';
        
         echo "<div style='text-align:right;color:gray'>asked by</div>";
       
         echo "<div style='text-align:right;color:rgb(70,189,196)'>".'<a href="profile.php?id='.$row["user_id"].'">'.htmlspecialchars($row["dname"]).'</a>'."</div>";
       
     
        break;
    }
} else {
    echo "0 results";
}
$sql = "SELECT answers.sno,answers.answer,answers.user_id,answers.votes,users.dname FROM answers,users where qno='".$_GET["id"]."' and users.sno=answers.user_id order by votes desc"; 
$result = mysqli_query($conn, $sql);
$c=mysqli_num_rows($result);
echo "<br>";
if($c<=1){
     echo "<h4><b>".$c." "."Answer"."</b></h4>";
}else{
      echo "<h4><b>".$c." "."Answers"."</b></h4>";
}
echo "<hr>";
if($result!=null){
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
            
      if(isset($_SESSION["user_id"])){$s=$_SESSION["user_id"];}else{$s=0;}
        
        $unique="'"."a".$row["sno"]."'";
        echo '<div class="w3-row">';
        
        
        echo '<div class="w3-col  w3-center" style="color:gray;width:30px;"><form>
<label><input type="radio" name='.$unique.' style="display:none;" onclick="showUser('.$unique.','.$row["user_id"].','.$s.',2,1,'.$row["sno"].');"><b  title="This is useful"style="cursor:pointer;font-size:30px">+</b></label>
<div id='.$unique.'>'.$row["votes"].'</div>
<label><input type="radio"style="display:none" name='.$unique.' onclick="showUser('.$unique.','.$row["user_id"].','.$s.',2,0,'.$row["sno"].');"><b title="This is not useful"style="cursor:pointer; font-size:30px">-</b>
</label>

</form></div>
';
          
        echo "<div class='w3-rest ' style='margin-left:40px'><p style='white-space: pre-wrap;background:none;border:none;line-height:;font-family:verdana'>".htmlspecialchars($row["answer"])."</p>" ;
        echo    ' 

<div class="fb-share-button" data-href="answers.php?id='.$_GET["id"].'" data-layout="button" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2F&amp;src=sdkpreparse"></a></div>';
        if(isset($_SESSION["user_id"])&&($row["user_id"]==$_SESSION["user_id"])||(isset($_SESSION["user_id"])&&$_SESSION["user_id"]==2)){
        
            echo '<a style="color:rgb(70,189,196);margin-left:20px" href="edit_answer.php?qid='.$_GET["id"].'&aid='.$row["sno"].'&id='.$row["user_id"].'#edit">edit</a> ';  
        }
        
        
        echo '</div></div>';

         echo "<div style='text-align:right;color:gray'>answered by</div>";
        
         echo "<div style='text-align:right;color:rgb(70,189,196)'>".'<a href="profile.php?id='.$row["user_id"].'">'.htmlspecialchars($row["dname"]).'</a>'."</div>";
    echo "<hr>";
       
    }
} 
}
?>

<form action="answers.php?id=<?php echo $_GET["id"];?>" method="post" onsubmit="var text = document.getElementById('minle').value; var ws = text.replace(/ /g,''); if(ws.length <= 40) { alert('Atleast 40 characters required!'); return false; } return true;">
   
  <?php
        if(!isset($_SESSION["user_id"])){
            echo '
<div class="w3-container w3-section " style="background:#f2f2f2">
<span onclick="this.parentElement.style.display='."'"."none"."'".'" class="w3-closebtn">&times;</span>
    <div class="">
  
        <p> <a href="signup.php" class=" btn w3-round">Sign up</a> or <a href="login.php" class=" btn w3-round">Log in</a>  and start contributing.</p>
    </div>
    
</div>';}?>
    <label>Your Answer</label><br>
        <div >
<p><textarea required name="answer" id="minle" placeholder="(Type your answer here, atleast 40 characters.)" class="w3-border w3-container w3-col m12" wrap="hard"  rows="10" id="comment"></textarea></p>
        </div>
    <script>
    jQuery('#minle').on('paste input', function() {
      <?php  if(!isset($_SESSION["user_id"])){
         echo  'alert("Please login to continue")';
           }
                ?>
    // do your stuff
        
});
    </script>
        <br>
        <div>
        <input class="btn w3-round" name="submit" type="submit" value="Post Your Answer">
        </div>
</form>
       
</p>
    </div>
    <div class="w3-third w3-container"><br>
         <div class="w3-container" style="padding:20px;background:#f2f2f2">
       <p>Tips for writing good answer:</p>
         
          <ul>
           <li>Read the question carefully. What, specifically, is the question asking for?</li><br>
          <li>We don't expect every answer to be perfect, but answers with correct formatting are easier to read. They also tend to get upvoted more frequently.</li><br>
          <li>Remember, you can always go back at any time and edit your answer to improve it.</li>
         
          
        </ul>
      
       
        </div>
     <p class="w3-border vl6  w3-container" style="color:grey"><i>
         <q> Debugging is twice as hard as writing the code in the first place. Therefore, if you write the code as cleverly as possible, you are, by definition, not smart enough to debug it. </q><br><br><span class="w3-right">- Brian Kernighan</span></i>
        </p>
        <p class="w3-border vl6  w3-container" style="color:grey"><i><q> If debugging is the process of removing software bugs, then programming must be the process of putting them in. </q> <br><br><span class="w3-right">- Edsger Dijkstra</span></i></p>
        
         <p class=" vl6  w3-container"></p>
        <p class=" vl6  w3-container"></p>
        <p class=" vl6  w3-container"></p>
    </div>
  </div>
<?php
if(isset($_POST["submit"])&&!empty($_POST["answer"]) ){
    
    
    if(!isset($_SESSION["user_id"] )){
        echo "<script type=\"text/javascript\">window.alert('You must log in before posting any answer');window.location.href = '';</script>";
    }
    else{
 $_POST["answer"]=mysqli_real_escape_string($conn, $_POST["answer"]);
 
$ans="'".$_POST["answer"]."'";

$sql = "INSERT INTO answers (qno, answer,user_id)
VALUES ('".$_GET["id"]."',$ans,'".$_SESSION["user_id"]."')";

if (mysqli_query($conn, $sql)) {
    echo "<script type=\"text/javascript\">window.alert('Answer Posted Sucessfully');window.location.href = 'answers.php?id=".$_GET["id"]."';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    }
}
?>
   
      
      
         
    </div>
      
     
      
   <?php
require("footer.php");
?>



</body>
</html>