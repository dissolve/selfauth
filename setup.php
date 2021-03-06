<html>
<head>
<title>
Setup Selfauth
</title>
<style>
h1{text-align:center;margin-top:5%;}
.instructions{text-align:center;}
.message{margin-top:20px;text-align:center;font-size:1.2em;font-weight:bold;}
pre {width:400px; margin-left:auto; margin-right:auto;margin-bottom:50px;}
form{ 
margin-left:auto;
width:300px;
margin-right:auto;
text-align:center;
margin-top:20px;
border:solid 1px black;
padding:20px;
}
.form-line{ margin-top:5px;}
.submit{width:100%}
</style>
</head>
<body>
<h1>Setup Selfauth</h1>
<div class="instructions">In order to configure Selfauth, you need to fill in a few values, this page helps generate those options.</div>
<?php if(isset($_POST['username'])):?>
<div>
<?php define('RANDOM_BYTE_COUNT', 32);

    $app_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] 
      . str_replace('setup.php', '', $_SERVER['REQUEST_URI']);

    if(function_exists('random_bytes')) {
        $bytes = random_bytes(RANDOM_BYTE_COUNT);
    } elseif(function_exists('openssl_random_pseudo_bytes')){
        $bytes = openssl_random_pseudo_bytes(RANDOM_BYTE_COUNT);
    } else {
        for ($i=0, $bytes=''; $i < RANDOM_BYTE_COUNT; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
    }
    $app_key = bin2hex($bytes);


    $user = $_POST['username'];

    $user_tmp = trim(preg_replace('/^https?:\/\//', '', $_POST['username']), '/');
    $pass = md5($user_tmp . $_POST['password'] . $app_key);

    $config_file_contents = "<?php
define('APP_URL', '$app_url');
define('APP_KEY', '$app_key');
define('USER_HASH', '$pass');
define('USER_URL', '$user');";



    $configfile= __DIR__ . '/config.php';

    $configured = true;

    if(file_exists($configfile)){

        require_once $configfile;
        
        if((!defined('APP_URL') || APP_URL == '')
            || (!defined('APP_KEY') || APP_KEY == '')
            || (!defined('USER_HASH') || USER_HASH == '')
            || (!defined('USER_URL') || USER_URL == '')
        ) {
            $configured = false;
        }
    } else {
        $configured = false;
    }

	$file_written = false;

    if(is_writeable($configfile) && !$configured){

		$handle = fopen($configfile, 'w');

		if($handle){
			$result = fwrite($handle, $config_file_contents);
			if($result !== FALSE){
				$file_written = true;
			}
			
		}

		fclose($handle);
    }


    if($file_written){
		echo '<div class="message">config.php was successfully written to disk</div>';
	} else {
        echo '<div class="message">Fill in the file config.php with the following content</div>';
        echo '<pre>';
        echo htmlentities($config_file_contents);
        echo '</pre>';
    }
 ?>
</div>
<?php endif ?>
<form method="POST" action="">
<div class="form-line"><label>Login Url:</label> <input name='username' /></div>
<div class="form-line"><label>Password:</label> <input type='password' name='password' /></div>
<div class="form-line"><input class="submit" type="submit" name="submit" value="Generate Config"/></div>
</form>
</body>
</html>
