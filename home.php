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
$userId=$row['userEmail'];
$username=$row['userName']
$filename=hash('sha256',strrev(substr($tempID,0,strpos($tempID,'@'))).$row['userPass']).".json";
$json_file = fopen($filename, "w");
*/
$username="Mouna";
$userId=15;
$filename='8bb96db453a58019d25531f97e9d34a5aa2f04d8b9b77ef9ef8116c363f85a31.json';
//$filename='sample.json';
date_default_timezone_set("Asia/Kolkata");

//$json_file = file_get_contents($filename);
//$stats = json_decode($json_file);
/* 
if(isset($_POST['id'])){
	echo "<br> hello ".$_POST['id'];
} */

$renew=0;
if(isset($_POST['id']) && isset($_POST['pin']) && isset($_POST['toggle'])){
  $deviceId = $_POST['id'];
  $gpioPin = $_POST['pin'];
  $toggle = $_POST['toggle'];
 // echo "Device Id = ".$deviceId." & pin = ".$gpioPin." is = ".$toggle;
$json_file = file_get_contents($filename);
$stats = json_decode($json_file);
$hits= $stats->count;
if($hits<2000){
$hits++;
$stats->count=$hits;
foreach ($stats->status as $i => $stat) {
	if(substr($stat->id,0,3) == $deviceId){
		$n='pin'.$gpioPin;
		//echo $stat->$n.strlen($stat->$n);
		$stat->$n=$toggle.substr($stat->$n,1,strlen($stat->$n)-1);
	}
}

$json = json_encode($stats, JSON_PRETTY_PRINT);
file_put_contents($filename, $json); 
}
else{
	$renew=1;
	echo "<script> alert('You Have Reahed Max Free Call/Month Limit');</script>";
}

}

if(isset($_POST['roomname'])){
	//save it on json
}  
  
$json_file = file_get_contents($filename);//
$stats = json_decode($json_file);

foreach ($stats->status as $i => $stat) {
//$id1="device-id";
//echo substr($stat->$id1,4,strlen($stat->$id1)-4);
$ids[$i]=substr($stat->id,0,3);
$room[$i]=substr($stat->id,4,strlen($stat->id)-4);

//echo "<br> ".$room[$i]." is ".$ids[$i];
// write here
$prev=$stat->lastseen;//"00:05:00"; //5 minutes
/* echo strtotime($prev);
echo "<br>".$prev;
echo "<br>".date('D d-m-Y h:i:s A');
echo "<br>".chr(date_diff( date_create($prev), date_create(date('D d-m-Y h:i:s A'))));
$tooltip="";
update($prev,$i,$room[$i]); */

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
	
$dialer[$i]="
<div  id='dialer".$i."' class='selector open ".(isset($_POST['id'])?(($ids[$i] !=  $deviceId)?"togglehide":""): "togglehide")."' style='top:55%; left:65%;'>
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
//btns will show the total no of devices at the top of the page
$btns[$i]="
<div  id='show".$i."' class='desc' data-toggle='tooltip' data-placement='bottom' data-original-title='". showtooltip($prev)."' style='top:10%; left:".(18*($i+1))."%;'>
           <div class='item'>
                <img src='img/image".($i+2).".png'>
                <div class='item_content'>
                    <h2>".$room[$i]."</h2><!-- $room[$i] will give us the romm name wher the device is installed -->
                </div>
            </div>
</div>
"; 

$display[$i]="
   <div class='togglehide popup' id='room".$i."'>
   <div id='msghead'>".$room[$i]." is Offline</div>		   
   <div id='msgbody'>last seen active on <div id='prev".$i."'>".$prev."</div></div>
   </div>
   ";
 // pop up menu ^^^^  
	 
//Dynamic Scripts for show and hide the dialers
    $scrpt[$i]="
    $('#show".$i."').click(function(){//alert('from php code');
		updateall(function(result){
			$('#prev".$i."').text(' -> '+ result[".$i."].substring(0,28)+':)'); 
			var prev=Math.round((new Date()- new Date(result[".$i."].substring(0,28)))/1000);";
	$size=count($stats->status);
	for($j=0;$j<$size;$j++){
		if($i!=$j){
			$scrpt[$i]=$scrpt[$i]."
			$('#dialer" .$j."').addClass('togglehide');
			$('#dialer" .$j."').removeClass('open');";
		}else{
			$scrpt[$i]=$scrpt[$i]."
			checkshow(".$i.",prev);";
		}
	}
	$scrpt[$i]=$scrpt[$i]."
		});
	});	
	 $('#roomicon1".$i."').click(function(){
		 $('#iconlist1".$i."').toggleClass('togglehide');//alert('testing');
	});
	 $('#roomicon2".$i."').click(function(){
		 $('#iconlist2".$i."').toggleClass('togglehide');//alert('testing');
	});
	 $('#roomicon3".$i."').click(function(){
		 $('#iconlist3".$i."').toggleClass('togglehide');//alert('testing');
	});
	 $('#roomicon4".$i."').click(function(){
		 $('#iconlist4".$i."').toggleClass('togglehide');//alert('testing');
	});
	$('.dropdown-content1 img').click(function(){
		var icn=$(this).attr('src')
		//alert(icn);
		var roomicon='#roomicon'+($(this).parent().attr('id').substring(8)) + ' img';
		//alert(roomicon);
		$(roomicon).attr('src',icn);
		
	});
	$('.dropdown-content2 img').click(function(){
		var icn=$(this).attr('src')
		//alert(icn);
		var roomicon='#roomicon'+($(this).parent().attr('id').substring(8)) + ' img';
		//alert(roomicon);
		$(roomicon).attr('src',icn);
		
	});
	$('.dropdown-content3 img').click(function(){
		var icn=$(this).attr('src')
		//alert(icn);
		var roomicon='#roomicon'+($(this).parent().attr('id').substring(8)) + ' img';
		//alert(roomicon);
		$(roomicon).attr('src',icn);
		
	});
	$('.dropdown-content4 img').click(function(){
		var icn=$(this).attr('src')
		//alert(icn);
		var roomicon='#roomicon'+($(this).parent().attr('id').substring(8)) + ' img';
		//alert(roomicon);
		$(roomicon).attr('src',icn);
		
	});";
//Customising te room naem and button name form; initially it shoud be hidden
//Change <imput>placeholder will show the current name like room21/ study room
//There will be arrow link; if you click it will slide down and show the 4 button name input fieldset
//similar to roo  name there alse be ->>> change <input> in beetween place holder vwill show the current button name like lap fan
// in the right side there will be a default icon shown, if u click the icon it will show the collection of icon 
//from there hr can choose the appropriate icon
 

$forms[$i]="
<!--	<h3 style='padding: 0px 10px;left:13px;position: relative;display: inline-block;'>Room Name:</h3>-->
	<div class='imagess' style='padding-top:3%;'>
	<div id='img1".$i."' class='icon_butn' style='position:absolute;top:15%;right:3%;'></div>
	<div id='img2".$i."' class='icon_butn' style='position:absolute;top:42%;right:3%;'></div>
	<div id='img3".$i."' class='icon_butn' style='position:absolute;top:68%;right:3%;'></div>
</div>
<!--	<div id='arrow'>	<img src='img/arrow.jpg'  style='width:40px;position:absolute;'>	</div>-->
<input type='text' id='changeroom".$i."' name='roomname' placeholder='".$room[$i]."' style='border: 2px solid #ccc;padding: 6px;margin:0px 20px 10px;' >
	<div class='roomicon'>
<div class='dropbtn' id='roomicon1".$i."' style='right:147px;'><img src='img/imageson/music-on.png' ></div>
<div id='iconlist1".$i."' class='dropdown-content1 togglehide' >
    <img id='icon1' src='img/imageson/fan-on.png'>
	<img id='icon3' src='img/imageson/bulb-on.png'>
	<img id='icon5' src='img/imageson/tube-on.png'>
	<img id='icon7' src='img/imageson/charger-on.png'>
	<img id='icon4' src='img/imageson/AC-on.png'>
	</div>
	<div class='roomicon'>
<div class='dropbtn' id='roomicon2".$i."' style='right:79px;'><img src='img/imageson/music-on.png'></div>
<div id='iconlist2".$i."' class='dropdown-content2 togglehide' >
    <img id='icon11' src='img/imageson/fan-on.png'>
	<img id='icon33' src='img/imageson/bulb-on.png'>
	<img id='icon55' src='img/imageson/tube-on.png'>
	<img id='icon77' src='img/imageson/charger-on.png'>
	<img id='icon44' src='img/imageson/AC-on.png'>
	</div>
	<div class='roomicon'>
<div class='dropbtn' id='roomicon3".$i."' style='right:9px;'><img src='img/imageson/music-on.png'></div>
<div id='iconlist3".$i."' class='dropdown-content3 togglehide' >
    <img id='icon111' src='img/imageson/fan-on.png'>
	<img id='icon333' src='img/imageson/bulb-on.png'>
	<img id='icon555' src='img/imageson/tube-on.png'>
	<img id='icon777' src='img/imageson/charger-on.png'>
	<img id='icon444' src='img/imageson/AC-on.png'>
	</div>
	<div class='roomicon'>
<div class='dropbtn' id='roomicon4".$i."' style='left:3px;'><img src='img/imageson/music-on.png'></div>
<div id='iconlist4".$i."' class='dropdown-content4 togglehide' >
    <img id='icon1111' src='img/imageson/fan-on.png'>
	<img id='icon3333' src='img/imageson/bulb-on.png'>
	<img id='icon5555' src='img/imageson/tube-on.png'>
	<img id='icon7777' src='img/imageson/charger-on.png'>
	<img id='icon4444' src='img/imageson/AC-on.png'>
	</div></div></div></div></div>
";
for($j=1;$j<=4;$j++){
	$scrpt[$i]=$scrpt[$i]."
	$('#img".$j.$i."').click(function(){
		$('#gallery').addClass('from_btn".$j.$i."');
		$('#gallery').show();
	});
";	
}

/*
$('.gallery').click(function(e){
	var offset = $(this).offset();
  var relativeX = (e.pageX - offset.left);
  var relativeY = (e.pageY - offset.top);
  var res=48;
  var posx='-'+Math.round(relativeX/res)*48+'px';
  var posy='-'+Math.round(relativeY/res)*48+'px';
  alert(posx+'\n'+posy);
  
   $('#myDropdown').hide();  
  $('.icongallery').css({'background-position-x': posx, 'background-position-y': posy});//.background-position();
});
";*/
/*     $scrpt[$i]="
    $('#show" .$i."').click(function(){//alert('from php code');
   ";
	$size=count($stats->status);
	for($j=0;$j<$size;$j++){
	If($t1<120)
	($i!=$j)?$scrpt[$i]=$scrpt[$i]."$('#dialer" .$j."').addClass('togglehide');$('#dialer" .$j."').removeClass('open');":$scrpt[$i]=$scrpt[$i]."$('#dialer" .$i."').removeClass('togglehide').delay(300);setTimeout(function() {toggleOptions($('#dialer" .$i."'));}, 100);";
   else	   	
	($i!=$j)?$scrpt[$i]=$scrpt[$i]."$('#dialer" .$j."').addClass('togglehide');$('#dialer" .$j."').removeClass('open');":$scrpt[$i]=$scrpt[$i]."$('#blur').show();$('#room".$i."').slideDown(300); setTimeout(function(){ $('#room".$i."').fadeOut(500); $('#blur').fadeOut(100);$('#blur').append('from php code');}, 5000);";
   
}
    $scrpt[$i]=$scrpt[$i]."
    });
   "; */
/*   $update="
   setInterval(function() {$.post( 'prevtime.php', { id : '".$userId."' }, function(data) {".
   $updt = json_decode('data');	
."
   alert(data);
       $('#show0').attr('data-original-title', data); 

//   window.location.href = 'ask.php';
});}, 10000);"; */
   /*
		BootstrapDialog.show({
            title: '".$room[$i]." Offline',
			message: '<img src=img/image2.png>Device is not Active'
        });
		 setTimeout(function(){ dialogRef.close();}, 5000);
		*/
  
/*   
if(isset($_POST['id'])){
	if($ids[$i] !=  $deviceId){
	$css[$i]="#dialer".$i." {
	display:none;
}
";
	} 
}
else{
$css[$i]="#dialer".$i." {
	display:none;
}
";
}*/
//end of dynamic web page
}

/*
sleep(3);
echo $_SERVER['PHP_SELF'];
$host = "localhost";
$path = "/email/home.php";//$_SERVER['PHP_SELF'];//
$data = "re=11";
$data = urlencode($data);

header("POST ".$path." HTTP/1.1\r\n");
header("Host: ".$host."\r\n");
header("Content-type: application/x-www-form-urlencoded\r\n");
header("Content-length: " . strlen($data) . "\r\n");
header("Content: " . $data . "\r\n");
//header("Connection: close\r\n\r\n");
*/
//$reload=0;
// $reload?$reload=0:$reload=1;
//header("refresh: 10;");


function showtooltip($prev) {

$interval=date_diff(date_create(date('D d-m-Y h:i:s A')),date_create($prev));
//echo "<br> diifrence is : ". $interval->y * 8760 + $interval->m * 730 + $interval->d *24;
$flag=1;
$tooltip= "last seen ";
//echo getTimestamp(date_diff($prev->getTimestamp(), )));
if($interval->y) 
{
 if($interval->y==1){
		 $tooltip=$tooltip. " last year";
		$flag=0;
	}
	else
		 $tooltip=$tooltip. $interval->y." years ";
}
elseif($interval->m) 
{
 if($interval->m==1){
		  $tooltip=$tooltip. " last month";
		$flag=0;
	}
	else
		 $tooltip=$tooltip. $interval->m." months ";
}
elseif($interval->d) 
{
	if($interval->d==1){
		  $tooltip=$tooltip. " yesterday ";
		$flag=0;
	}
	else
		 $tooltip=$tooltip. $interval->d." days ";
}
elseif($interval->h) 
{
  $tooltip=$tooltip. $interval->h." hours ";
}
elseif($interval->i) 
{
  $tooltip=$tooltip. $interval->i." minutes ";
}
elseif($interval->s) 
{
  $tooltip=$tooltip. $interval->s." seconds ";
}
//else{echo "<br>Hello";}

If($flag)
 $tooltip=$tooltip. "ago";

//echo  "<br>".$tooltip;
//echo "device is offline";// ahve a back up of tis code//ok
return $tooltip;
}
// ________________

/* function checktime($prev){   
$t1=date_timestamp_get(date_create(date('D M d, Y h:i:s A')))-date_timestamp_get(date_create($prev));
//$t3=$t1-$t2 ;
    //echo "<br>".  $t1;
   
 return $t1;
}
 */
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home <?php echo $username;?></title>
  <!--   <META HTTP-EQUIV="refresh" CONTENT="120">
 <php
      if(reload==0){
      header("re=11");
   }
   ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https:////maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
<link href="style1.css" rel="stylesheet">
<!--<link href="style2.css" rel="stylesheet">-->
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="http://quablu.in/QuasarEnterprises.png" rel="icon" type="image/x-icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
<style>
.icon_butn{
	background:url("img/images.jpg") center top no-repeat scroll;
	width: 48px;
height: 48px;
display: inline-block;
margin: 0px 5px;

	
}
#gallery{
	width:384px;
	height:192px;
}
.btn-group-lg > .btn, .btn-lg {
font-size:10px;
}
.togglehide{
	display:none;
}
.alertbox{
	height:100%;
	width:100%;
	background-color:rgba(0, 0, 0, 0.4);
	position:absolute;
	-moz-transition: opacity 1s ease-in-out;
}
.popup{
	left: 25%;
	top:25%;
position: absolute;
border-radius: 18px;
border: 12px solid #000000;
box-shadow: 50px 49px 28px -14px rgba(0,0,0,0.66);
}
#msghead{
	background-color: red;
	color:white;
	padding:5px;
	text-align:center;
}
#msgbody{
	background-color: white;
	padding:20px;
	text-align:center;
}

.settings_btn img {
position:absolute;
right:3%;
top:3%;
}
.logout_btn img {
	position:absolute;
	right:11%;
	top:2%;
}
.settings_panel {
    position:absolute;
	left: 31%;
	top: 23%;
	background-color: #f9f9f9;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	opacity: 1;
    filter: alpha(opacity=50);
	width:35%;
}
.icongallery{
	display: none;
	position:absolute;
	left: 31%;
	top: 23%;
	background-color: #f9f9f9;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	opacity: 0.5;
    filter: alpha(opacity=50); 

}
.icongallery img{
	color: black;
    text-decoration: none;
    display: block;
}
/*.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}*/

.dropdown a:hover {background-color: #f1f1f1}

.show {display:block;}

.button {
    background-color:skyblue;
    border: none;
    color: white;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 0px 2px;
    cursor: pointer;
	position:absolute;
	left:93%;
	top:5%;
}
.image	1{
	width:30%;
	height:5%;
	margin-top:4%;
}
#arrow{
	display: inline-block;
position: absolute;
padding: 16px 0px;
}

.dropbtn {
	color: white;
    padding: 2px;
    font-size: 16px;
    border: none;
    cursor: pointer;
	background: -webkit-linear-gradient(top, #4c4e5a 0%,#2c2d33 100%);
    background: -moz-linear-gradient(top, #4c4e5a 0%,#2c2d33 100%);
    background: -o-linear-gradient(top, #4c4e5a 0%,#2c2d33 100%);
    background: -ms-linear-gradient(top, #4c4e5a 0%,#2c2d33 100%);
    background: linear-gradient(top, #4c4e5a 0%,#2c2d33 100%);
 
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
	width: 48px;
	height: 48px;
	display: inline-block;
	margin: 0px 5px;
	top:50px;
}
.dropbtn img {
	width: 48px;
	height:48px;
}
.dropbtn:hover, .dropbtn:focus {
    background-color: #3e8e41;
}

.roomicon {
    position: relative;
    display: inline-block;
}

.dropdown-content1 {
    position: absolute;
	right:135px;
	top:75px;
    background-color: #f9f9f9;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	max-height: 200px;
	z-index: 99;
}

.dropdown-content1 a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
	
}
.dropdown-content1 img{
	width:60px;
	height:60px;
}
.dropdown-content2 {
    position: absolute;
	right:50px;
	top:75px;
    background-color: #f9f9f9;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	max-height: 200px;
	z-index: 99;
}

.dropdown-content2 a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
	
}
.dropdown-content2 img{
	width:60px;
	height:60px;
}
.dropdown-content3 {
    position: absolute;
	right:0px;
	top:75px;
    background-color: #f9f9f9;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	max-height: 200px;
	z-index: 99;
}

.dropdown-content3 a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
	
}
.dropdown-content3 img{
	width:60px;
	height:60px;
}
.dropdown-content4 {
    position: absolute;
	right:-50px;
	top:75px;
    background-color: #f9f9f9;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	max-height: 200px;
	z-index: 99;
}

.dropdown-content4 a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
	
}
.dropdown-content4 img{
	width:60px;
	height:60px;
}


</style>
<script>
function updateall(callback) {
	$.post( 'update.php', { id : <?php echo $userId; ?> }, function(data) { 	//alert(data);
		callback(JSON.parse(data));
	});
}
function checkshow(i,prev){//alert(prev);
	if(prev<120){
		$('#dialer'+i).removeClass('togglehide').delay(300);
		setTimeout(function(){toggleOptions($('#dialer'+i));}, 100);
		$('.popup').hide();
		$('#blur').hide();
	}else{
		$('#blur').show();$('#room'+i).slideDown(500).fadeIn('fast');
		setTimeout(function(){
			$('#room'+i).fadeOut(500);
			$('#blur').fadeOut(100);
		}, 5000);
	}	
}

$(document).ready(function(){
//var dial; 
 $('[data-toggle="tooltip"]').tooltip();   
 $('.alertbox').click(function(){$('.alertbox').hide();$('.popup').hide();});
 
 $('.settings_btn').click(function(){
	if($('.settings_panel').hasClass('togglehide')){
	//update the settings field
	$.post( 'update.php', { settings : <?php echo $userId; ?> }, function(data) { 	//alert("dhgd ff "+data);
		//callback(JSON.parse(data));
		var result=JSON.parse(data);
		for(var i=0;i<result.length;i++){
			for(var j=0;j<5;j++){
				if(!j){
					var rname='#changeroom'+i;//alert(rname);
					$(rname).val("");
					$(rname).attr('placeholder',result[i][j]);
					alert('Room '+i+' is a '+result[i][j]);
				}else{
					
					alert('Button '+j +' is a '+result[i][j]);
				}
			}
			//alert(pin[i]);
		}
	});
	
	}	
$('.settings_panel').toggleClass('togglehide');
});

<?php
  try{
  if(count($scrpt)>0){
	foreach($scrpt as $i =>$scripts){
		echo $scripts;
	}
  }
  } catch (Exception $e) {
	 // echo '//Caught exception: ',  $e->getMessage(), "\n";904629735
  }
 ?>
 $('.icongallery').click(function(e){
	var offset = $(this).offset();
  var relativeX = (e.pageX - offset.left);
  var relativeY = (e.pageY - offset.top);
  var res=48;
  var posx='-'+Math.round(relativeX/res)*48+'px';
  var posy='-'+Math.round(relativeY/res)*48+'px';//  alert(posx+'\n'+posy);
  // get the claassnmae from that we can know whhere we have clicked it
   
  var myClass = $(this).attr("class");//   alert(myClass); icongallery from_btn40
if(myClass.indexOf("from_btn")>0)  {
	var btn=myClass.substr(myClass.indexOf("from_btn")+8,1);
	var room=myClass.substr(myClass.indexOf("from_btn")+9,1);
    var selct="#img" + btn+room;// alert(selct);
  $('.icongallery').hide();  
  $(selct).css({'background-position-x': posx, 'background-position-y': posy});//.background-position();
 selct="from_btn" + btn+room;// alert(selct);
 $(this).removeClass(selct);
}//else alert(myClass.indexOf("from_btn"));
});
});
/* 
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();   
	$('.alertbox').click(function(){$('.alertbox').hide();$('.popup').hide();});


}); */
setInterval(function() {
	updateall(function(result){
		for(var i=0;i<result.length;i++){
			$('#prev1').text(' -> '+ result[i].substring(0,28)+':)'); 
			var prev=Math.round((new Date()- new Date(result[i].substring(0,28)))/1000);
			if(prev>120){//				alert(prev + "#dialer" +i);
				if(!($("#dialer" +i).hasClass('togglehide'))){//					alert("Dialer");
					$("#dialer" +i).addClass('togglehide');
					$("#dialer" +i).removeClass('open');
					$('#blur').show();$('#room'+i).slideDown(500).fadeIn('fast');
					setTimeout(function(){
						$('#room'+i).fadeOut(500);
						$('#blur').fadeOut(100);
					}, 5000);
				}//else alert("Dialer "+i +" already hidden");
			}			
		}
	});
}, 120000);// try to understand
/* setTimeout(function() { 
  <?php
  try{
  if(count($scrpt)>0){
	foreach($scrpt as $i =>$scripts){
		echo $scripts;
	}
	
  }
  } catch (Exception $e) {
	 // echo '//Caught exception: ',  $e->getMessage(), "\n";904629735
  }
 ?>
  }, 100); */
/* setInterval(function() {$.post( 'update.php', { id : <?php echo $userId; ?> }, function(data) {
	var result = JSON.parse(data);
	//alert("time now "+new Date($.now()));
	//alert(data);
	//var time=[];
    for(var i=0; i<result.length; i++) {
		$("#show" + i).attr('data-original-title', result[i].substr(28)+":)"); 
		$("#prev" + i).text(" -> "+ result[i].substring(0,28)+":)"); 
	}	

	
$('.desc').click(function(){
		i=$(this).attr('id').substr(4);
		$('#blur').text(i);// var val=time[i];
		var prev=Math.round((new Date()- new Date(result[i].substring(0,28)))/1000);
		//alert(i+"\n"+prev);//alert(new Date(val.substring(0,28)) +"\n" +(new Date()- new Date(val.substring(0,28)))+"\n" +prev); 
	for(var j=0;j<result.length;j++){
		if(i!=j){
			$('#blur').append("hide evrything");
			$("#dialer" +j).addClass('togglehide');
			$("#dialer" +j).removeClass('open');
			$(".popup").hide();// alert("others");
		}else{
			if(prev<120){
				$('#blur').append(" -"+prev);	//alert("online");
				$(".popup").hide();
				$("#blur").hide();//alert("online");
				$("#dialer"+i).removeClass('togglehide').delay(300);
				setTimeout(function(){
					toggleOptions($("#dialer"+i));
					}, 100);
				
			}else{
				$('#blur').append(" +"+prev);
				$('#blur').show();
				$("#room"+j).slideDown(500);
				setTimeout(function(){
					$("#room" +j).fadeOut(500);
					$('#blur').fadeOut(100);
					}, 5000);//alert("offline");
			}
		}
	}
});
	
});}, 20000); */
/*$(document).ready(function(){
    $(".imagess").click(function(){
        $(".box").show();
    });
});*/
 </script>
</head>

<body style="background-color:skyblue;">
<?php
echo "<div class='roombtn' style='position:absolute; width: 100%;'>";
if(count($btns)>0){
	foreach($btns as $i =>$buttons){
		echo $buttons;
	}
}
echo "</div>";

if(count($dialer)>0){
for($i=0;$i<count($dialer);$i++){
 echo $dialer[$i];
 
}
}
echo "<div class='togglehide alertbox' id='blur'></div>";
if(count($display)>0){
		foreach($display as $i =>$dspl){
		echo $dspl;
	}
}

/* echo "<div class='agileinfo_main'><form id='survey-form' action='#' method='post' target='submit-survey'>";
if(count($form)>0){
		foreach($form as $i =>$formfields){
		echo $formfields;
	}
}
echo "</form></div>"; */
?>
<div class="settings_btn" style="padding-top:3%;"><img src="img/settings.ico" alt="Settings">
</div>
<!--<div class="dropbtn"></div>
<div class="dropbtn"></div>
<div class="dropbtn"></div>-->
 <div class="logout_btn"><a href="index.php" style="color:white;" onclick="return confirm('Are you sure, you want to Logout?');">
 <img  src="img/image8.png" alt="Logout"></a></div>
 

 <div id="settings" class="settings_panel togglehide">
	<div style="text-align:center;"><h2>Settings</h2></div>
   <div style="padding: 10px;">
   <form  method="post" action='home.php'>
<?php 
if(count($forms)>0){
		foreach($forms as $i =>$frm){
		echo $frm;
	}
}
?>
<button type='submit' style='display: block;color: red;border: 2px;'>Save</button>
    </form></div>
  </div>
  
  
 <div id="gallery" class="icongallery">
 <img src="img/images.jpg">
 </div>
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
/*function myFunction() {
   // document.getElementById("myDropdown").classList.toggle("show");//this is plain java script use jquery instead
	 $('#myDropdown').toggleClass('show');
}*/
/*$('.gallery').click(function(e){
	var offset = $(this).offset();
  var relativeX = (e.pageX - offset.left);
  var relativeY = (e.pageY - offset.top);
  var res=48;
  var posx='-'+Math.round(relativeX/res)*48+'px';
  var posy='-'+Math.round(relativeY/res)*48+'px';
  alert(posx+'\n'+posy);
  
   $('#myDropdown').hide();  
  $('.icongallery').css({'background-position-x': posx, 'background-position-y': posy});//.background-position();
});*/
// Close the dropdown if the user clicks outside of it
/* window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
 */
</script>

	<script type="text/javascript" src="switcher.js"></script>

</body>
</html>