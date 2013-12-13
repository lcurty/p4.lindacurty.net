<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($title)) echo $title; ?></title>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
    
        <!-- Global JS/CSS -->
        <link href='http://fonts.googleapis.com/css?family=Cherry+Swash:400,700' rel='stylesheet' type='text/css'>
        <link href="/css/styles.css" rel="stylesheet" type="text/css" media="all">	
    
        <!-- Controller Specific JS/CSS -->
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
        
    </head>
    
    <body>  
        <br>
        <?php if($user): ?><div id="logged_in"><?php else: ?><div id="logged_out"><?php endif; ?>
        	<div id="outer">
                <div id="page">
                    <nav>
                        <a href='/'>Home</a>
                    
                        <!-- Menu for users who are logged in -->
                        <?php if($user): ?>
                            <a href='#'>Your Farm</a>
                            <a href='#'>Farm Feed</a>
                            <a href='/posts/users'>Follow Farmers</a>
                            <a href='/users/logout'>Logout</a>
                    
                        <!-- Menu options for users who are not logged in -->
                        <?php else: ?>
                            <a href='/users/signup'>Sign up</a>
                            <a href='/users/login'>Log in</a>
                    
                        <?php endif; ?>
						<hr class="clear">
                    </nav>
                    
                    <header>
                        <img src="/images/chipper-chirper.png">
                        <img class="left" src="/images/chuck-logo.png">
                    </header>
                    
                    <?php if(isset($content)) echo $content; ?>
                    
                    <?php if(isset($client_files_body)) echo $client_files_body; ?>
                </div>
            </div>
        </div>
    </body>
</html>