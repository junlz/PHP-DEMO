<?php


$fd = stream_socket_server("tcp://127.0.0.1:8090",$errno,$errstr);
stream_set_blocking($fd,0);
$event_base = new EventBase();
$event = new Event(
	$event_base,$fd,Event::READ | Event::PERSIST,function($fd) use (&$event_base){
	$conn = stream_socket_accept($fd);
	fwrite($conn,"HTTP/1.0 200 ok \r\n Content-Length:2 \r\n\r\nHi");

	},$fd);
$event->add();
$event_base->loop();

?>
