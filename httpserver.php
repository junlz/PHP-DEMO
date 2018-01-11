<?php
$sock = stream_socket_server("tcp://127.0.0.1:8989",$errno,$errstr);
$pids = [];

//leader-follower模型
for($i=0;$i<10;$i++)
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
/**
*这样，我们的WEB服务器的处理能力又上了一个台阶，可以同时处理10个并发，当然这个能力还会随着你的进程池中进程的数量提升。那是不是意味着只要我们无限加大进程的数量，就可以处理无限的并发呢？遗憾的是，事实并不是这样。

首先，系统创建进程的开销是大的，系统并不能无限地创建进程，因为每一个进程都占用一定的系统资源，而系统的资源是有限的，不可能无限地创建。

其次，大量进程带来的上下文切换，也会带来巨大的资源消耗和性能浪费。

所以使用大量地创建进程的方式来提升并发，是不可行的。那么，没有办法了么？难道没有一种技术在单进程里就可以维持成千上万的连接么？下一章我们将介绍IO复用技术，使我们WEB服务器的并发处理量再次提升。
*/
?>
