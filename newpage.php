<?php
@include 'config.php';

session_start();




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user page</title>
<style>

body {
      
      background-image: URL( 'photo/back1.svg');
      background-repeat: no-repeat;
      background-size: cover;
      
      font-size: small;
      text-align: left;
      /*color: #3a2134;*/
     }
    .container{
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    
    padding-bottom: 30px;
    padding-left: 0px;
    padding-right: 600px;
    padding-top: 0px;

}

.container .content{
    text-align: center;

}

.container .content h3{
    font-size: 30px;
    color: #333;

    
}

.container .content h3 span{
    
    color: #fff;
    border-radius: 5px;
    padding: 0 15px;
}

.container .content h1{
    font-size: 30px;
    color: #333;

    
}

.container .content h1 span{
    color: crimson;
    
}
.container .content p{
font-size: 25px;
margin-bottom: 20px;
}



.wrap {
  height: 100%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.container .button {
  min-width: 300px;
  min-height: 60px;
  display: inline-block; 
  font-family: 'Nunito', sans-serif;
  font-size: 22px;
  align-items: center;
  justify-content: center;
  text-transform: uppercase;
  text-align: center;
  letter-spacing: 1.3px;
  font-weight: 700;
  color: #313133;
  background: #4FD1C5;
  background: linear-gradient(90deg, rgba(129,230,217,1) 0%, rgba(79,209,197,1) 100%);
  border: none;
  border-radius: 1000px;
  box-shadow: 10px 5px 5px red;
  transition: all 0.3s ease-in-out 0s;
  cursor: pointer;
  outline: none;
  position: relative;
  padding: 10px;
  }

.button::before {
content: '';
  border-radius: 1000px;
  min-width: calc(300px + 12px);
  min-height: calc(60px + 12px);
  border: 6px solid #00FFCB;
  box-shadow: 0 0 60px rgba(0,255,203,.64);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: all .3s ease-in-out 0s;
}

.button:hover, 
.button:focus {
  color: #313133;
  transform: translateY(-6px);
}

.button:hover::before, 
.button:focus::before {
  opacity: 1;
}

.button::after {
  content: '';
  width: 30px; height: 30px;
  border-radius: 100%;
  border: 6px solid #00FFCB;
  position: absolute;
  z-index: -1;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation: ring 1.5s infinite;
}

.button:hover::after, 
.button:focus::after {
  animation: none;
  display: none;
}

@keyframes ring {
  0% {
    width: 30px;
    height: 30px;
    opacity: 1;
  }
  100% {
    width: 300px;
    height: 300px;
    opacity: 0;
  }
}
    

    
   
            </style>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">

        <div class="content">
       <!--  <h1> welcome <span><?php echo ($_SESSION['user_name'])?></span><h1> -->
            <p>Please Select Hall That You Want  </p>

            <form action="south_hall.php" method="post">
        
        <input class="button" type="submit" id="south-hall" value="South hall ">
      </form>
      <br>
      
      <form action="north_hall.php" method="post">
        
        <input  class="button" type="submit" id="north-hall" value=" North hall">
      </form>
      <br>
      <form action="center_hall.php" method="post">
        
        <input class="button" type="submit" id="central-hall" value=" Center hall">
      </form>
    </div>

        </div>
</body>
</html>