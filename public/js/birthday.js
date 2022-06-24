let year = document.getElementById('year');
let month = document.getElementById('month');
let day = document.getElementById('day');
let old_year = document.getElementById('old_year').value;
let old_month = document.getElementById('old_month').value;
let old_day = document.getElementById('old_day').value;
function make_year(){
    let y_now = new Date().getFullYear();
    for(let y=y_now;y>y_now-125;y--){
        let o = document.createElement('option');
        o.value = y;
        o.textContent = y;
        o.selected = old_year==y?true:false;
        year.appendChild(o);
    }
}

function make_month(){
    for(let m=1;m<13;m++){
        let o = document.createElement('option');
        o.value = m;
        o.textContent = m;
        o.selected = old_month==m?true:false;
        month.appendChild(o);
    }    
}
function make_day(){
    $(day).empty();
    let d = new Date();
    d.setFullYear(parseInt(year.value));
    d.setMonth(parseInt(month.value));
    d.setDate(0);
    let max_d = d.getDate();
    for(let md=1;md<=max_d;md++){
        let o = document.createElement('option');
        o.value = md;
        o.textContent = md;
        o.selected = old_day==md?true:false;
        day.appendChild(o);
    }    
    old_day = "";
    console.log(d.getDate());
}
make_year();
make_month();
make_day();
year.addEventListener("change",make_day);
month.addEventListener("change",make_day);
