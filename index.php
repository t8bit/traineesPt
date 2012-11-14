<?php
//Always place this code at the top of the Page
session_start();
if (!isset($_SESSION['id'])){
	 //Load on start
	header("Location: login-facebook.php");
}

if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'facebook') {
        header("Location: login-facebook.php");
    }
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
<script>
$('#video').load('app/video.php');
</script>
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

	<br />   
</div>
<pre>
<?php
	if(isset($_SESSION['user_profile']))
	{
		print_r($_SESSION);
		echo "<div id='video'><img src='images/load.gif'/></div>"
		echo "<a href='logout.php?logout'>Logout</a>";
	}
 ?>
</pre>
