    let socket = io("192.168.10.116:3120");
    let stylist_id = document.getElementById('stylist_id').value;
    let customer_id;
    let url = document.getElementById('url').value;
    let csrf = document.getElementById('csrf').value;
    let message_body = document.getElementById("message");    
    let message_box = document.getElementById('message_box');
    let customer_list_box = document.getElementById('customer_list_box');
    let customer_info_box = document.getElementById('customer_info');
    let origin = document.getElementById('origin').value;
    let customer_list;
    let customer_info;
    let first = true;
    let reserve_name = document.getElementById("reserve_name");
    socket.emit('stylist_join',stylist_id);
    console.log(origin);
    //textareaにshift+enterキーでメッセージ送信
    message_body.addEventListener('keyup',function(e){
        if(e.shiftKey){
            if(e.keyCode==13){
                sendMsg();
            }
        }
    })
    //socketサーバーとデータベースにメッセージを送信
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
    //予約のurlを送信する
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
    //自分が送ったメッセージを表示する
    socket.on('from_stylist',function(msg){
        make_message_stylist(msg);
        scrollToBottom();
    })
    //顧客からのメッセージを表示する
    socket.on('from_customer',function(msg){
        if(msg[1]==customer_id){
            make_message_customer(msg[0]);
            scrollToBottom();    
        }
    })
    //顧客の一覧を獲得する
    function get_customer_list(){
        $.ajax({
            url:customer_list_url,
            type:'POST',
            data:{"_token":customer_csrf},
            success:function(c_list){
                $(customer_list_box).empty();
                // let index = 0;
                customer_list = c_list;
                for(let i=0;i<c_list.length;i++){
                    let customer = c_list[i];
                    let li = document.createElement("li");
                    let a = document.createElement("a");
                    let img = document.createElement("img");
                    let p = document.createElement("p");
                    a.classList.add("dropdown-item");
                    a.classList.add("customer_item");
                    a.classList.add("d-flex");
                    a.classList.add("align-items-center");
                    a.classList.add("justify-content-between");
                    a.classList.add("border-bottom")
                    a.href = "javascript:void(0);";
                    a.addEventListener("click",function(){
                        change_customer_message(origin + 'chat/stylist_user_get_message',customer_csrf,customer.id,i);                        
                    })
                    img.src = origin + customer.icon;
                    img.width = '30px';
                    img.height = '30px';
                    img.style.borderRadius = "50%";
                    img.style.height = '30px';
                    img.style.width = '30px';
                    // p.textContent = customer.name + ":" + customer.readed;
                    p.textContent = customer.name;
                    p.style.margin = "0";
                    a.appendChild(img);
                    a.appendChild(p);
                    if(customer.readed!="0"){
                        let span = document.createElement("span");
                        span.classList.add("badge");
                        span.classList.add("bg-danger");
                        span.classList.add("rounded-pill");
                        span.textContent = customer.readed;    
                        a.appendChild(span);
                    }
                    li.appendChild(a);
                    customer_list_box.appendChild(li);
                    // index++;
                    // console.log(customer);
                }
                if(first){
                    change_customer_message(origin + 'chat/stylist_user_get_message',customer_csrf,c_list[0].id,0);
                    first = false;
                }
            },
            error:function(msg){
                console.log(msg);
            }            
        })
    }
    //顧客からのメッセージを画面に表示する
    function make_message_customer(message){
        let out_div = document.createElement("div");
        let inner_div = document.createElement("div");
        let pre = document.createElement("pre");
        let img = document.createElement("img");
        out_div.classList.add("other_side");
        inner_div.classList.add("inner_div");
        pre.textContent = message;
        img.src = origin + customer_info.icon;
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
    //自分が送ったメッセージを画面に表示する
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
    //選択した顧客のメッセージを表示する
    function change_customer_message(url,csrf,id,index){
        $.ajax({
            url:url,
            type:"post",
            data:{"_token":csrf,customer_id:id},
            success:function(msg_list){
                $(message_box).empty();
                customer_id=id;         
                customer_info = customer_list[index];
                for(msg of msg_list){
                    // console.log(msg);
                    if(msg['from']==0){
                        make_message_stylist(msg['text']);
                    }else{
                        make_message_customer(msg['text']);
                    }
                }
                console.log(customer_info);
                reserve_name.textContent = customer_info.name;
                scrollToBottom();
                change_customer_info();
                get_customer_list();
                console.log(2);
            },
            error:function(msg){
                console.log(msg);
            }
        })
    }
    //選択した顧客の情報を表示する
    function change_customer_info(){
        $(customer_info_box).empty();
        let a = document.createElement("a");
        let img = document.createElement("img");
        let p = document.createElement("p");
        a.classList.add("d-flex");
        a.classList.add("link-dark");
        a.classList.add("text-decoration-none");
        a.classList.add("h5");
        a.style.width = "auto";
        a.style.margin = "0px";
        p.style.marginLeft = "5px";
        p.style.marginBottom = "0px";
        a.href = origin + 'user/show/' + customer_info.id;
        a.target = '_blank';
        img.src = origin + customer_info.icon;
        img.width = '30px';
        img.height = '30px';
        img.style.borderRadius = "50%";
        img.style.height = '30px';
        img.style.width = '30px';
        p.textContent = " " + customer_info.name;
        a.appendChild(img);
        a.appendChild(p);
        customer_info_box.appendChild(a);
    }
    //scrollbarを常に一番下に表示する
    function scrollToBottom(){
        message_box.scrollTo(0,message_box.scrollHeight);
    }
    //予約を作る画面で、選択したサービスを追加する
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
    //予約を作る画面を開く
    function open_reverse(){
        document.getElementById("reverse").style.display = "block";
    }
    //予約を作る画面を閉じる
    function close_reverse(){
        document.getElementById("reverse_form").reset();
        $("#service_area").empty();
        let options = document.getElementById("service_select").children;
        for(let i= 1;i<options.length;i++){
            options[i].disabled = false;
        }
        document.getElementById("reverse").style.display = "none";
    }
    //予約を作る
    function make_reserve(url){
        let start_time = document.getElementById("start_time").value;
        let end_time = document.getElementById("end_time").value;
        let price = document.getElementById("price").value;
        let services = document.getElementById("service_area").textContent;
        console.log(start_time);
        let today = new Date();
        if(!start_time){
            alert("開始時間を選択してください");
        }else if(!end_time){
            alert("終了時間をを選択してください");
        }else if(new Date(start_time)<today){
            alert("開始時間を今より遅い時間を選択してください");
        }else if(new Date(end_time)<today){
            alert("終了時間を今より遅い時間を選択してください");
        }else if(new Date(start_time)>new Date(end_time)){
            alert("終了時間を開始時間より遅い時間を選択してください");
        }else if(!services){
            alert("サービス内容を選択してください");
        }else if(!price){
            alert("料金を入力してください");
        }else if(price_check(price)){
            alert("料金を正整数を入力してください");
        }else{
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
    }
    function price_check(money){
        if(money.toString().indexOf('.')!=-1||parseInt(money)<=0){
            return true;
        }
        return false;
    }

    get_customer_list();
    

