<?php
// Start the session
session_start();
if(isset($_SESSION["user_id"])){
    
}
else{
    echo "<script type=\"text/javascript\">window.alert('Please login to ask question');window.location.href ='./login.php';</script>";
}
?>
<?php
require("db.php");
if(isset($_POST['title']) && $_POST['title']!=null && $_POST['description']!=null){
    $_POST['description'] = mysqli_real_escape_string($conn, $_POST['description']);
    $_POST['title'] = mysqli_real_escape_string($conn, $_POST['title']);
    
  
$sql = "INSERT INTO questions (title, description,user_id)
VALUES ('".$_POST['title']."','".$_POST['description']."','".$_SESSION["user_id"]."')";
    
   
if (mysqli_query($conn, $sql)) {
     $query = mysqli_query($conn,"select max(sno) from questions where user_id='".$_SESSION["user_id"]."' ");
    $row=mysqli_fetch_assoc($query);
     file_put_contents("sitemap1.txt", "http://www.bytepoch.com/answers.php?id=".$row["max(sno)"]. "\n", FILE_APPEND);
  
    echo "<script type=\"text/javascript\">window.alert('Question posted sucessfully');window.location.href = 'answers.php?id=".$row["max(sno)"]."';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<title>Ask Question | Bytepoch</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="rohit2.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="rohit.css">
   
<body style="background:#f2f2f2;"> 
  
<?php
require("header.php");
?>
    
    <div class="w3-content w3-white" style="max-width:1075px">


    <div class="w3-row ">
    <div class="w3-twothird w3-container">
        
      <p>
        <form action="questions.php" method="post" onsubmit="var text = document.getElementById('minle').value; 
        var ws = text.replace(/ /g,''); 
        if(ws.length <= 40) { alert('Atleast 40 characters required!'); 
                                                             return false; } 
        return true;">
    <label>Title</label>
    <input required name="title"  pattern=".{15,300}" title="15 to 300 characters are required" placeholder="Atleast 15 characters but not more than 300 characters, so be specific." class="w3-input w3-border" type="text">
    
    <br>
    
    <label>Description</label><br>
        <div>
           <textarea required name="description" placeholder="(Type description here, atleast 40 characters.)"id="minle" class="w3-border w3-col m12 w3-container" wrap="hard" rows="10" id="comment"></textarea>
        </div>
        <br>
        <div>
            
        <input class="btn w3-round " type="submit" value="Post Your Question">
        </div>
    </form>
        </p>
    </div>
    <div class="w3-third w3-container">
     
      <br>
        <div class="" style="padding:20px;background:#f2f2f2">
       <p>Tips for writing good question?</p>
          <p>Title:</p>
          <ul>
           <li>Be specific and try to sum up your entire question in one sentence.</li><br>
          <li>Remember, this is the first part of your question others will see - you want to make a good impression.</li><br>
          <li>Example: Why does using float instead of int give me different results when all of my inputs are integers?</li>
         
          
        </ul>
      
        <p>Description:</p>
        <ul>
        <li> In the description of your question, start by expanding on the summary you put in the title.</li> <br>
            <li>Explain how you encountered the problem you're trying to solve, and any difficulties that have prevented you from solving it yourself.</li> <br>
            <li>The first paragraph in your question is the second thing most readers will see, so make it as engaging and informative as possible.</li><br>
             <li>Read the question after posting it and edit of you have missed something.</li>
          
        </ul>
        </div>
        <p class=" vl6  w3-container"></p>
        <p class=" vl6  w3-container"></p>
        <p class=" vl6  w3-container"></p>
    </div>
  </div>
</div>
      
  <?php
require("footer.php");
?>



</body>
</html>