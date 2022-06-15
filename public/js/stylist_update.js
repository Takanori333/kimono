    function imgChange(img) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            let imgFile =ev.target.result;
            document.getElementById("img").src= ev.target.result;
        }
        reader.readAsDataURL(img.files[0]);
    }
    function insert_area(url,csrf,o){
        $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,area:o.value},
            success:function(area){
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        }
        )
        console.log(1);
    }
    function delete_area(url,csrf,area){
        $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,area:area},
            success:function(area){
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        }
        )
        console.log(1);
    }
    function insert_service(url,csrf,o){
        $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,service:o.value},
            success:function(area){
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        }
        )
        console.log(1);
    }
    function delete_service(url,csrf,service){
        $.ajax({
            url:url,
            type:"POST",
            data:{"_token": csrf,service:service},
            success:function(area){
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        }
        )
        console.log(1);
    }