function add_new_time(url,csrf){
    let start_time = document.getElementById("start_time").value;
    let end_time = document.getElementById("end_time").value;
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