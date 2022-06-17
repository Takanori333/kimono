    let socket = io("192.168.10.209:3120");
    let stylist_id = document.getElementById('stylist_id').value;
    let customer_id;
    let url = document.getElementById('url').value;
    let csrf = document.getElementById('csrf').value;
    let message_body = document.getElementById("message");    
    let message_box = document.getElementById('message_box');
    socket.emit('stylist_join',stylist_id);
    message_body.addEventListener('keyup',function(e){
        if(e.shiftKey){
            if(e.keyCode==13){
                sendMsg();
            }
        }
    })
    function sendMsg(){
        if(message_body.value){
            socket.emit('stylist_send',{stylist_id:stylist_id,customer_id:customer_id,message:message_body.value});
            $.ajax({
                url:url,
                type:'POST',
                data:{"_token":csrf,stylist_id:stylist_id,customer_id:customer_id,message:message_body.value,from:0},
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
    function sendUrl(reserve){
        socket.emit('stylist_send',{stylist_id:stylist_id,customer_id:customer_id,message:reserve});
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":csrf,stylist_id:stylist_id,customer_id:customer_id,message:reserve,from:0},
            success:function(){
                console.log(1);
            },
            error:function(msg){
                console.log(msg);
            }
        })
    }
    socket.on('from_stylist',function(msg){
        make_message_stylist(msg);
        scrollToBottom();
    })
    socket.on('from_customer',function(msg){
        make_message_customer(msg);
        scrollToBottom();
    })
    function make_message_customer(message){
        let out_div = document.createElement("div");
        let inner_div = document.createElement("div");
        let pre = document.createElement("pre");
        out_div.classList.add("other_side");
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
        out_div.classList.add("self");
        inner_div.classList.add("inner_div");
        pre.textContent = message;
        inner_div.appendChild(pre);
        out_div.appendChild(inner_div);    
        message_box.appendChild(out_div);
    }
    function change_customer_message(url,csrf,id){
        $.ajax({
            url:url,
            type:"post",
            data:{"_token":csrf,customer_id:id},
            success:function(msg_list){
                $(message_box).empty();
                for(msg of msg_list){
                    // console.log(msg);
                    if(msg['from']==0){
                        make_message_stylist(msg['text']);
                    }else{
                        make_message_customer(msg['text']);
                    }
                }
                customer_id=id;                
                scrollToBottom();
            },
            error:function(msg){
                console.log(msg);
            }
        })
    }
    function insert_service(e){
        let area = document.getElementById("service_area");
        let out_div = document.createElement('div');
        let e_value = e.value;
        out_div.classList.add("border");
        out_div.classList.add("secondary");
        out_div.style.margin = "3px";
        out_div.style.padding = "5px";
        out_div.textContent = e_value+" ";
        let cancel_a = document.createElement("a");
        cancel_a.classList.add("link-danger");
        cancel_a.href = "javascript:void(0);";
        cancel_a.addEventListener("click",function(){
            for(let select_e of e){
                if(select_e.value == e_value){
                    select_e.disabled = false;
                    e.value = "0";
                    break;
                }
            }
            $(cancel_a.parentElement).remove();
        });
        let cancel_a_text = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'><path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/></svg>";
        cancel_a.innerHTML = cancel_a_text;
        out_div.appendChild(cancel_a);
        area.appendChild(out_div);
        for(let select_e of e){
            if(select_e.value == e.value){
                select_e.disabled = true;
                e.value = "0";
                break;
            }
        }
    }
    function open_reverse(){
        document.getElementById("reverse").style.display = "block";
    }
    function close_reverse(){
        document.getElementById("reverse_form").reset();
        $("#service_area").empty();
        let options = document.getElementById("service_select").children;
        for(let i= 1;i<options.length;i++){
            options[i].disabled = false;
        }
        document.getElementById("reverse").style.display = "none";
    }
    function scrollToBottom(){
        message_box.scrollTo(0,message_box.scrollHeight);
    }
    function make_reserve(url){
        let start_time = document.getElementById("start_time").value;
        let end_time = document.getElementById("end_time").value;
        let price = document.getElementById("price").value;
        let services = document.getElementById("service_area").textContent;
        $.ajax({
            url:url,
            type:"post",
            data:{"_token":csrf,customer_id:customer_id,stylist_id:stylist_id,start_time:start_time,end_time:end_time,price:price,services:services},
            success:function(reserve_url){
                sendUrl(reserve_url);
                close_reverse();
            },
            error:function(msg){
                console.log(msg);
            }
        })
    }
    $(document.getElementsByClassName('customer_item')[0]).click();
