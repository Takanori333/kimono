<?php
require_once __DIR__.'../../../vendor/autoload.php';
use Workerman\Worker;
use PHPSocketIO\SocketIO;
use App\Models\Stylist_chat;
use Illuminate\Support\Facades\DB;

$io = new SocketIO(3120);
$io->on('connection',function ($socket)use($io){
        // $io->emit("welcome","hello");        
        stylist_join($socket,$io);
        stylist_customer_join($socket,$io);
        stylist_send($socket,$io);
        stylist_customer_send($socket,$io);
        trade_join($socket,$io);
        trade_send($socket,$io);
    });

function user_join(&$socket,&$io){
    
}

//スタイリストがチャット画面に入る時、このスタイリストのチャンネルを作る
function stylist_join(&$socket,&$io){
    $socket->on('stylist_join',function ($id)use ($io,$socket){
        $socket->join('stylist:'.$id);
    });
}
//スタイリスト顧客がチャット画面に入る時、この顧客のチャンネルを作る
function stylist_customer_join(&$socket,&$io){
    $socket->on('stylist_customer_join',function ($id)use ($io,$socket){
        $socket->join('stylist_customer:'.$id);
    });
}
//スタイリストからのメッセージをスタイリストと顧客に送る
function stylist_send(&$socket,&$io){
    $socket->on('stylist_send',function ($msg)use ($io,$socket){
        $io->to('stylist_customer:'.$msg['customer_id'])->emit('from_stylist',$msg['message']);
        $socket->emit('from_stylist',$msg['message']);
    });
}
//スタイリスト顧客からのメッセージをスタイリストと顧客に送る
function stylist_customer_send(&$socket,&$io){
    $socket->on('stylist_customer_send',function ($msg)use ($io,$socket){
        $io->to('stylist:'.$msg['stylist_id'])->emit('from_customer',[$msg['message'],$msg['customer_id']]);
        $socket->emit('from_customer',$msg['message']);
    });
}
//ユーザがフリーマチャットに入る時に、このユーザのチャンネルを作る
function trade_join(&$socket,&$io){
    $socket->on('trade_join',function ($id)use ($io,$socket){
        $socket->join('trade:'.$id);
    });
}
//フリーマチャットのメッセージを送る
function trade_send(&$socket,&$io){
    $socket->on('trade_send',function ($msg)use ($io,$socket){
        $io->to('trade:'.$msg['getter_id'])->emit('from_other_side',$msg['message']);
        $socket->emit('from_self',$msg['message']);
    });
}
function disconnect(&$socket,&$io,&$user){
    $socket->on('disconnect',function($msg)use($io,$socket,&$user){
    });
}


Worker::runAll();