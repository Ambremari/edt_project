<script>
    function position(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        for(var i = 0 ; i < div.length ; i++){
            var time = div[i].getAttribute("class");
            if(/LU/.test(time))
                div[i].style.left = "0px";
            if(/MA/.test(time))
                div[i].style.left = "180px";
            if(/ME/.test(time))
                div[i].style.left = "360px";
            if(/JE/.test(time))
                div[i].style.left = "540px";
            if(/VE/.test(time))
                div[i].style.left = "720px";
            if(/SA/.test(time))
                div[i].style.left = "900px";
        }

        for(var i = 0 ; i < div.length ; i++){
            var time = div[i].getAttribute("class");
            if(/M1/.test(time))
                div[i].style.top = "40px";
            if(/M2/.test(time))
                div[i].style.top = "130px";
            if(/M3/.test(time))
                div[i].style.top = "220px";
            if(/M4/.test(time))
                div[i].style.top = "310px";
            if(/M5/.test(time))
                div[i].style.top = "400px";
            if(/S1/.test(time))
                div[i].style.top = "530px";
            if(/S2/.test(time))
                div[i].style.top = "620px";
            if(/S3/.test(time))
                div[i].style.top = "710px";
            if(/S4/.test(time))
                div[i].style.top = "800px";
        }
    }

    function color1(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        for(var i = 0; i < div.length ; i++){
            var check1 = div[i].getElementsByTagName("input")[0];
            var check2 = div[i].getElementsByTagName("input")[1];
            if(check1){
                if(check1.checked){
                    check2.checked = false;
                    div[i].style.backgroundColor= "#DC5757";
                }
                else if(!check1.checked && !check2.checked)
                    div[i].style.backgroundColor= "#f6f5f5";
            }
        }
    }

    function color2(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        for(var i = 0; i < div.length ; i++){
            var check1 = div[i].getElementsByTagName("input")[0];
            var check2 = div[i].getElementsByTagName("input")[1];
            if(check2){
                if(check2.checked){
                    check1.checked = false;
                    div[i].style.backgroundColor= "#EAD76D";
                }
                else if(!check1.checked && !check2.checked)
                    div[i].style.backgroundColor= "#f6f5f5";
            }
        }
    }
</script>
