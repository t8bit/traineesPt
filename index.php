<?php
//Always place this code at the top of the Page
session_start();
if (isset($_SESSION['id'])){
	 // Redirection to login page twitter or facebook
	 // header("location: home.php");
	 //load this page;
}

if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'facebook') {
        header("Location: login-facebook.php");
    }
}
?>
<title>Facebook Login</title>
<style type="text/css">
    #buttons
	{
	text-align:center
	}
    #buttons img,
    #buttons a img
    { border: none;}
	h1
	{
	font-family:Arial, Helvetica, sans-serif;
	color:#999999;
	}
	
</style>



<div id="buttons">
<h1>Facebook Login </h1>
    <a href="?login&oauth_provider=facebook"><img src="images/fb_login.png"></a> <br />
	<br />   
</div>
<pre>
<?php
	if(isset($_SESSION['user_profile']))
	{
		print_r($_SESSION);
		echo "<a href='logout.php?logout'>Logout</a>";
	}
 ?>
</pre>
