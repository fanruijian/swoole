<?php
$ws = new Swoole\WebSocket\Server('0.0.0.0',9502);

$ws->on('open',function($ws,$request){
    var_dump($request->server,$request->fd);
    $ws->push($request->fd, "hello, welcome\n");
});

$ws->on('message',function($ws,$frame){
    echo 'message: {$frame->data}';
    $ws->push($frame->fd, "server: {$frame->data}");
});

$ws->on('close',function($ws,$fd){
    echo 'client {$fd} is closed';
});

$ws->start();