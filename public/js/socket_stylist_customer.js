let socket = io("192.168.10.209:3120");
let stylist_id = document.getElementById('stylist_id').value;
let customer_id = document.getElementById('customer_id').value;
let url = document.getElementById('url').value;
let csrf = document.getElementById('csrf').value;
let message_box = document.getElementById('message_box');
let message_body = document.getElementById("message");
socket.emit('stylist_customer_join',customer_id);
message_body.addEventListener('keyup',function(e){
    if(e.shiftKey){
        if(e.keyCode==13){
            sendMsg();
        }
    }
})
function sendMsg(){
    if(message_body.value){
        socket.emit('stylist_customer_send',{stylist_id:stylist_id,customer_id:customer_id,message:message_body.value});
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":csrf,stylist_id:stylist_id,customer_id:customer_id,message:message_body.value,from:1},
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
socket.on('from_stylist',function(msg){
    if(msg[1]==stylist_id){
        make_message_stylist(msg[0]);
        scrollToBottom();    
    }
})
socket.on('from_customer',function(msg){
    make_message_customer(msg);
    scrollToBottom();
})

function make_message_customer(message){
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
function make_message_stylist(message){
    let out_div = document.createElement("div");
    let inner_div = document.createElement("div");
    let pre = document.createElement("pre");
    let img = document.createElement("img");
    out_div.classList.add("other_side");
    inner_div.classList.add("inner_div");
    pre.textContent = message;
    img.src = stylist_icon;
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
function scrollToBottom(){
    message_box.scrollTo(0,message_box.scrollHeight);
}
scrollToBottom();
