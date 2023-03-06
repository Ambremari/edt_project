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
</script>
