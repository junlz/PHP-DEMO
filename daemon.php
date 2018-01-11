<?php
function daemon(){
	umask(0);
	if(pcntl_fork()){
	   exit(0);
	}
	posix_setsid();
	if(pcntl_fork()){
	  exit(0);
	}


}
daemon();

$sock = stream_socket_server("tcp://127.0.0.1:8989",$errno,$errstr);
$pids = [];

// 10 bingfa
for($i=0;$i<5;$i++)
{
   $pid = pcntl_fork();
	$pids[] = $pid;
	if($pid == 0){
	 for(; ; ){
	  $conn = stream_socket_accept($sock);
	  $write_buffer = "HTTP/1.0 200 ok \r\nServer:junlz\r\nContent-Type:text/html;charset=utf-8\r\n\r\n HelloWorld";
	  fwrite($conn,$write_buffer);
	  fclose($conn);
	 }
	 
	exit(0);
	}



}

foreach($pids as $pid){
	pcntl_waitpid($pid,$status);
}
?>
