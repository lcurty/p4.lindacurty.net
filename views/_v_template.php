<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title; ?></title>
    
		<meta charset="utf-8">
    
        <!-- Global CSS -->
		<link href='http://fonts.googleapis.com/css?family=Rum+Raisin' rel='stylesheet' type='text/css' media="all">
        <link href="/css/styles.css" rel="stylesheet" type="text/css" media="all">	
        <link href="/js/jquery-ui-1.10.3.custom/css/blitzer/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" media="all">
        
        <!-- Global JS -->
        <script src="/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="/js/filter.js" type="text/javascript"></script>
		<script>
			$(function() {
				$( "#born_date" ).datepicker();
				$( "#acquired_date" ).datepicker();
				$( "#gone_date" ).datepicker();
				$( "tr:even").addClass('even');
			});
        </script>
   
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
        
    </head>
    
    <body>  

        <header>
            <img src="/images/farm-friends-logo.png">
        </header>
        
        <div id="page">
            <nav>
                <a href='/'>Home</a>
            
                <!-- Menu for users who are logged in -->
                <?php if($user): ?>
                    <a href='/users/profile'>Your Farm</a>
                    <a href='/posts/index'>Farm Feed</a>
                    <a href='/posts/users'>Follow Farmers</a>
                    <a href='/users/edit'>Edit Profile</a>
                    <a href='/users/logout'>Logout</a>
            
                <!-- Menu options for users who are not logged in -->
                <?php else: ?>
                    <a href='/users/signup'>Sign up</a>
                    <a href='/users/login'>Log in</a>
            
                <?php endif; ?>
                <hr class="clear">
            </nav>
            <div id="main">
				<?php if(isset($content)) echo $content; ?>
                <?php if(isset($client_files_body)) echo $client_files_body; ?>
            </div>
        </div>
        

                
    </body>
</html>