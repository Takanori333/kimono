let socket = io("192.168.10.209:3120");
let sender_id = document.getElementById('self_id').value;
let getter_id = document.getElementById('other_side_id').value;
let item_id = document.getElementById('item_id').value;
let url = document.getElementById('url').value;
let csrf = document.getElementById('csrf').value;
let message_box = document.getElementById('message_box');
let message_body = document.getElementById("message");
socket.emit('trade_join',sender_id);
message_body.addEventListener('keyup',function(e){
    if(e.shiftKey){
        if(e.keyCode==13){
            sendMsg();
        }
    }
})
function sendMsg(){
    if(message_body.value){
        socket.emit('trade_send',{sender_id:sender_id,getter_id:getter_id,message:message_body.value});
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":csrf,from:sender_id,item_id:item_id,message:message_body.value},
            success:function(){
                console.log(1);
            },
            error:function(msg){
                console.log(msg);
            }
        })        
        message_body.value = "";    
    }
}
socket.on('from_self',function(msg){
    make_message_self(msg);
    scrollToBottom();
})
socket.on('from_other_side',function(msg){
    if(msg[1]==getter_id){
        make_message_other_side(msg[0]);
        scrollToBottom();    
    }
})

function make_message_other_side(message){
    let out_div = document.createElement("div");
    let inner_div = document.createElement("div");
    let pre = document.createElement("pre");
    let img = document.createElement("img");
    out_div.classList.add("other_side");
    inner_div.classList.add("inner_div");
    pre.textContent = message;
    img.src = other_side_icon;
    img.width = '30px';
    img.height = '30px';
    img.style.borderRadius = "50%";
    img.style.height = '30px';
    img.style.width = '30px';
    inner_div.appendChild(pre);
    out_div.appendChild(img);
    out_div.appendChild(inner_div);    
    message_box.appendChild(out_div);
}
function make_message_self(message){
    let out_div = document.createElement("div");
    let inner_div = document.createElement("div");
    let pre = document.createElement("pre");
    out_div.classList.add("self");
    inner_div.classList.add("inner_div");
    pre.textContent = message;
    inner_div.appendChild(pre);
    out_div.appendChild(inner_div);    
    message_box.appendChild(out_div);
}
function scrollToBottom(){
    message_box.scrollTo(0,message_box.scrollHeight);
}
function changeTradeStatus(trade_url,trade_csrf,e){
    let bol = confirm("取引ステージを変更するのがよろしいでしょうか？");
    if(bol){
        $(e).remove();
        $.ajax({
            url:trade_url,
            type:'POST',
            data:{"_token":trade_csrf,"id":item_id},
            success:function(){
            },
            error:function(msg){
                console.log(msg);
            }
        })    
    }
}
scrollToBottom();
