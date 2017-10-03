
<!DOCTYPE HTML>
<html>
<head>
 <title>Geolocation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
 


<style>

body {
   font-family: "Lato", sans-serif;
    margin: 0 0;
   

 background-color: black;}


 .inputs {
          
            
           
            color: black;
            height: 30px;
            width:140px;
            font-size: 18px;
           
            border-radius: 4px;
           margin: 5px;
         
         
           text-align: center;
        }


.flash {
   animation-name: flash;
    animation-duration: 0.4s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-play-state: running;
    margin:auto;
    text-align: center;
}

@keyframes flash {
    from {color: red;}
    to {color: black;}
}



  </style>
 
 


 <style>
      
.numeros {
      
	
	
	
      position: block;
          margin:auto;
     
	
           background-color: blue  ;
         
            width:300px;
            height: 500px;
            border: none;
            color: white;
            text-align: center;
           
          
            border-radius: 8px;
 
            border: 3px solid #f1f1f1;
        }


button {
    background-color: red;
    color: white;
    padding: 14px 20px;
    margin: auto;
    border: none;
    font-weight: bold;
    width:280px;
    height: 60px;
    font-size: 30px;
   text-align: center;
   
}

button:hover {
    opacity: 0.8;
}

    </style>

 <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>

</head>

<body  >








<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWZCv2AB_oka9hOsHyb1ivPFr_768L0fE&callback=initMap"
  type="text/javascript"></script>


<script src="geoPosition.js"></script>


<script type="text/javascript">



function getLocation() 
{

 

if (document.getElementById("tagid").value == ''  )
               {

   alert ("You must  Enter the Tag Id you want to track")  ;

                }
else 
    
     {



    if (navigator.geolocation) 
        {
      
       

        navigator.geolocation.getCurrentPosition(showPosition,showError);

        

        } 

       else
            { 

                alert ( "Geolocation is not supported by this browser.")  ;
            }
       }

 }


function showError(error) 
{
var x = document.getElementById("demo");

    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
                       }
}
                    

function showPosition(position) 

  {


document.getElementById("latitud").value =position.coords.latitude ;

document.getElementById("longitud").value =position.coords.longitude ;


var dist = position.coords.accuracy;

document.getElementById("metros").value =  dist.toFixed(2) ;




document.getElementById("link").value =  "http://www.google.com/maps/place/" + document.getElementById("latitud").value  + "," +  document.getElementById("longitud").value ;
   
if (document.getElementById("metros").value < 100)
{


document.getElementById("pases").value =Number(document.getElementById("pases").value ) + 1;
document.forms["gpsForm"].submit();

}


else
{
document.getElementById("pasesno").value =Number(document.getElementById("pasesno").value ) + 1;

}

}


</script>





  

<script  type="text/javascript">

function stoptrack() 

  {


  var link2 = document.getElementById("flashing");
  link2.style.display = 'none';

window.close();

 }

</script>






    <?php




include("config.php");
session_start();

 $_SESSION['tagid'] = $_POST['gpstag2'];

$tagid = $_SESSION['tagid'];
$mensaje= $_POST["mensaje"] ;
$setinterval=$_POST["setinterval"] ;



$showDivFlag2=true ;



 $sql1 = "SELECT * FROM inventory WHERE tagid = '$tagid' ";

$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) 

            {
    
    

      $row = $result1->fetch_assoc() ;
      $setinterval= $row["setinterval"] ;
     
         }


?>

 <br>

<div class = "numeros">


  <br>

<h1 class="flash" id="flashing" <?php if ($showDivFlag2===false){?> style="display:none"<?php } ?>>TRACKING</h1>
  <br>
<button   onclick="stoptrack()">Stop Tracking</button>
 
<br>

  <br>
     

 <p id="demo"  style=" margin:auto; background-color: yellow; color: black; height:80px;  max-width: 280px; font-size:18px;" ><?php echo $mensaje; ?></p>  


 <br >

<form id="gpsForm" name="gpsForm" method="post"   action =  "http://ugpson.com/GPStracking.php"  >

 

<input type="text"  style="color:black; height:30px; text-align:center;  width: 200px; font-size:25px;" name="tagid" placeholder="Phone # to Track" id= "tagid" readonly  value = "<?php echo $tagid; ?>"/>
<br>



 <input type="hidden"  class  ="inputs" style="display:none"  name="latitud" id="latitud"  readonly>
<span>
 <input type="hidden"  class  ="inputs"  style="display:none"  name="longitud" id="longitud" readonly >
</span>
 


 <input type="text" class  ="inputs" placeholder = "Accuracy" name="metros" id="metros"  readonly >
<br>
<input type="text" class  ="inputs" style="color:green;" placeholder = "enviados" name="pases" id="pases" readonly >

<input type="text" class  ="inputs"  style="color:red;" placeholder = "no enviados" name="pasesno" id="pasesno" readonly >
<input type="text" class  ="inputs"  style="color:red;" placeholder = "intervalo" name="setinterval" id="setinterval" readonly value = "<?php echo $setinterval; ?>">
<input type="hidden"  class  ="inputs"  name="link" id="link"  >
   
 
</form> 

</div>




  <script>


  
  var temp= <?php echo json_encode($setinterval); ?>;
      temp = temp * 60000 ;  

 
  var myVar = setInterval(getLocation, temp);

 
 

</script>




</body>
</html>   
  