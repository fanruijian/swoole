<?php
$ws = new Swoole\WebSocket\Server('0.0.0.0',9502);

$ws->on('open',function($ws,$request){
    var_dump($request->server,$request->fd);
    Swoole\timer::tick(1000,function(){
        echo '一秒执行一次';
    });
    $ws->push($request->fd, "hello, welcome\n");
});

$ws->on('message',function($ws,$frame){
    echo 'message: {$frame->data}';
    Swoole\timer::after(2000,function() use($ws,$frame){
        $ws->push($frame->fd, "每两秒推送一次");
    });
    $ws->push($frame->fd, "server: {$frame->data}");
});

$ws->on('close',function($ws,$fd){
    echo 'client {$fd} is closed';
});

$ws->start();