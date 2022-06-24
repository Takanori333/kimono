function add_new_time(url,csrf){
    let start_time = document.getElementById("start_time").value;
    let end_time = document.getElementById("end_time").value;
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
    }else{
        $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,start_time:start_time,end_time:end_time},
            success:function(){
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        }
        )
    }
}
function delete_time(url,csrf,id){
    $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,id:id},
            success:function(msg){
                location.reload();
                // console.log(msg);
            },
            error:function(msg){
                console.log(msg);
            }
        }
    )
}
function change_status(url,csrf,check){
    let status = check.checked?1:2;
    $.ajax({
        url:url,
        type:"POST",
        data:{"_token": csrf,status:status},
        success:function(msg){
            // location.reload();
            console.log("ok");
        },
        error:function(msg){
            console.log(msg);
        }
    }
)
}