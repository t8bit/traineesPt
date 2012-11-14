<?php
session_start();
include('videoManap.php');
$id=$_SESSION['id'];
$auth_id=$_SESSION['oauth_id'];
$email=$_SESSION['email'];
$oauth_provider=$_SESSION['oauth_provider'];
$vm = new videoManapulator($id,'4.MOV');
shell_exec('chmod -R 777 .');
shell_exec('mkdir '.$id);
shell_exec('mkdir '.$id.'/videos.out');
shell_exec('mkdir '.$id.'/images.src');
$vm->decode();
$vm->add_filter(25,10,580,190,$id,$auth_id,$username,$email,$oauth_provider,$t6);
$vm->encode();
?>
<a href='app/<?php echo $id ?>/videos.out'>Video</a>
