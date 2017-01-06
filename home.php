<?php  
// send the command to NodeMCU - /change.php?id=NM2&pin=16&toggle=0
/*session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$tempID=$row['userEmail'];
$filename=hash('sha256',strrev(substr($tempID,0,strpos($tempID,'@'))).$row['userPass']).".json";
$json_file = fopen($filename, "w");
*/


$json_file = file_get_contents('sample.json');
$stats = json_decode($json_file);

if(isset($_POST['id']) && isset($_POST['pin']) && isset($_POST['toggle'])){
  $deviceId = $_POST['id'];
  $gpioPin = $_POST['pin'];
  $toggle = $_POST['toggle'];
 // echo "Device Id = ".$deviceId." & pin = ".$gpioPin." is = ".$toggle;
$json_file = file_get_contents('sample.json');
$stats = json_decode($json_file);
foreach ($stats->status as $i => $stat) {
	if(substr($stat->id,0,3) == $deviceId){
		$n='pin'.$gpioPin;
		//echo $stat->$n.strlen($stat->$n);
		$stat->$n=$toggle.substr($stat->$n,1,strlen($stat->$n)-1);
	}
}
 
$json = json_encode($stats, JSON_PRETTY_PRINT);
file_put_contents('sample.json', $json); 
 }
  
  
$json_file = file_get_contents('sample.json');
$stats = json_decode($json_file);

foreach ($stats->status as $i => $stat) {
//$id1="device-id";
//echo substr($stat->$id1,4,strlen($stat->$id1)-4);
$ids[$i]=substr($stat->id,0,3);
$room[$i]=substr($stat->id,4,strlen($stat->id)-4);

//echo "<br> ".$room[$i]." is ".$ids[$i];

$p16="pin16";
$pin16s[$i]=substr($stat->$p16,0,1);

$p5="pin05";
$pin5s[$i]=substr($stat->$p5,0,1);

$p4="pin04";
$pin4s[$i]=substr($stat->$p4,0,1);

$p0="pin00";
$pin0s[$i]=substr($stat->$p0,0,1);

//echo " pin16 = ".$pin16s[$i]." pin5 = ".$pin5s[$i]." pin4 = ".$pin4s[$i]." pin0 = ".$pin0s[$i];

//dynamic web page starts here
$btns[$i]="
<div class='desc' style='top:20%; left:".(15*($i+1))."%;'>
           <div class='item'>
                <img src='img/image".($i+2).".png'>
                <div class='item_content'>
                    <h2>".$room[$i]."</h2>
                </div>
            </div>
</div>
";

$dialer[$i]="
<div class='selector ".(($i==1)?'':'open')."' style='top:70%; left:".(350*($i+1))."px;'>
  <ul>
    <li>
      <input id='c1' type='checkbox'>
      <label for='c1'>
	  <form action='home.php' method='post'>
<p><input type='text' name='id' style='display:none;' value='".$ids[$i]."'/></p>
<p><input type='text' name='pin' style='display:none;' value='16'/></p>
<p><input type='text' name='toggle' style='display:none;' value='".($pin16s[$i]?0:1)."'/></p>
 <button type='submit' style='display: block;margin-top: -10px;color: transparent;border: none;'><img class='image' id='myImage1' src='img/image".($pin16s[$i]?1:2).".png'>16</button>
</form>
</label>
    </li>
    
    <li>
      <input id='c3' type='checkbox'>
      <label for='c3'><form action='home.php' method='post'>
<p><input type='text' name='id' style='display:none;' value='".$ids[$i]."'/></p>
<p><input type='text' name='pin' style='display:none;' value='05'/></p>
<p><input type='text' name='toggle' style='display:none;' value='".($pin5s[$i]?0:1)."'/></p>
 <button type='submit' style='display: block;margin-top: -10px;color: transparent;border: none;'><img class='image' id='myImage1' src='img/image".($pin5s[$i]?3:4).".png'>5</button>
</form></label>
    </li>
    
    <li>
      <input id='c5' type='checkbox'>
      <label for='c5'><form action='home.php' method='post'>
<p><input type='text' name='id' style='display:none;' value='".$ids[$i]."'/></p>
<p><input type='text' name='pin' style='display:none;' value='04'/></p>
<p><input type='text' name='toggle' style='display:none;' value='".($pin4s[$i]?0:1)."'/></p>
 <button type='submit' style='display: block;margin-top: -10px;color: transparent;border: none;'><img class='image' id='myImage1' src='img/image".($pin4s[$i]?5:6).".png'>4</button>
</form></label>
    </li>
    
    <li>
      <input id='c7' type='checkbox'>
      <label for='c7'><form action='home.php' method='post'>
<p><input type='text' name='id' style='display:none;' value='".$ids[$i]."'/></p>
<p><input type='text' name='pin' style='display:none;' value='00'/></p>
<p><input type='text' name='toggle' style='display:none;' value='".($pin0s[$i]?0:1)."'/></p>
 <button type='submit' style='display: block;margin-top: -10px;color: transparent;border: none;'><img class='image' id='myImage1' src='img/image".($pin0s[$i]?7:8).".png'>0</button>
</form></label>
    </li>
    
  </ul>
  <button><img src='img/mob3.png'  style='border-radius:35%;'></button>
</div>
";
//end of dynamic web page
}
?>



<!DOCTYPE html>
<html>
<head>
<title>Welcome Home <?php echo $_GET['uname'];?></title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"> </script>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https:////maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="style1.css" rel="stylesheet">
<!--
	<script >

    $(function() {


   var people = [];

   $.getJSON('new1.json', function(data) {
       $.each(data.status, function(i, f) {
          var tblRow = "<th>" + "<td onclick='show1()'>" + f.id + "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" +
		  "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" + "&nbsp" + "</td>" + "</th>" 
		  
           $(tblRow).appendTo("#userdata tbody");
		   
     });

   });

});
</script>
-->

<style>
.btn-group-lg > .btn, .btn-lg {
font-size:10px;
}


table, tr, td , th {
  border: 0px;
}

th {
display:none;
}
.wrapper {
margin-top: 100px;
margin-left: 200px;
}
.selector li {
position:absolute;
width:100px;
left:-50px;

}
.selector {

}
</style>


</head>

<body style="background-color:skyblue;">

<div class="wrapper">
<div class="profile">
   <table id= "userdata" border="2">
  <thead>
            <th>id</th>
        </thead>
      <tbody>

       </tbody>
   </table>
   
</div>
</div>

<?php
if(count($btns)>0){
	foreach($btns as $i =>$buttons){
		echo $buttons;
	}
}
if(count($dialer)>0){
for($i=0;$i<count($dialer);$i++){
 echo "<div>".$dialer[$i]."</div><br>";
}
}
?>

<!--

<div class='selector'>
  <ul>
    <li>
      <input id='c1' type='checkbox'>
      <label for='c1'><a href=?id=NM1&pin=16&toggle=1><img class="image" onclick="javascript:change1()" id="myImage1" src="img/image1.png" ></a></label>
    </li>
    
    <li>
      <input id='c3' type='checkbox'>
      <label for='c3'><a href="?id=NM1&pin=05&toggle=1"><img class="image" onclick="javascript:change2()" id="myImage2" src="img/image3.png" ></a></label>
    </li>
    
    <li>
      <input id='c5' type='checkbox'>
      <label for='c5'><a href="?id=NM1&pin=04&toggle=1"><img class="image" onclick="javascript:change3()" id="myImage3" src="img/image5.png" ></a></label>
    </li>
    
    <li>
      <input id='c7' type='checkbox'>
      <label for='c7'><a href="?id=NM1&pin=00&toggle=1"><img class="image" onclick="javascript:change4()" id="myImage4" src="img/image7.png" ></a></label>
    </li>
    
  </ul>
  <button><img src="img/mob3.png"  style="border-radius:35%;"></button>
</div>

-->

<script>

</script>
				
			
	<!--
        <script src="jquery-css-transform.js" type="text/javascript"></script>
        <script src="jquery-animate-css-rotate-scale.js" type="text/javascript"></script>
 
	-->

	
	<!-- jQuery Library 
	<script type="text/javascript" src="assets/js/jquery-2.1.0.min.js"></script>-->
		<!-- Plugins -->
	<!-- Color Style Switcher -->
	<script type="text/javascript" src="switcher.js"></script>

</body>
</html>