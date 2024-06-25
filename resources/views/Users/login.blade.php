<!DOCTYPE html>
<html>
<head>
    
	<title>E-commerce</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="{{asset('img/wave.png')}}">
	<div class="container">
		<div class="img">
			<img src="{{asset('img/bg.svg')}}">
		</div>
		<div class="login-content">
			<form action="{{route('login')}}" method="POST">
                @csrf
				<img src="{{asset('img/avatar.svg')}}">
				<h2 class="title">Welcome</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" class="input" name="name">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password">
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>
</body>
</html>
