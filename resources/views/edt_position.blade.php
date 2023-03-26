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

    function associateColor(){
        var colors = ["#FBCEB1", "#F2D2BD", "#E97451",	"#E3963E","#F28C28",	
                    "#D27D2D",	"#B87333","#FF7F50",	"#F88379",	"#8B4000",	
                    "#FAD5A5","#E49B0F","#FFC000",	"#DAA520",	"#FFD580"];
        var index = 0;
        var getColor = new Map();
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[0];
            var text = mySpan.getAttribute("class");
            if(!getColor.has(text)){
                getColor.set(text, colors[index])
                index++;
                if(index >= colors.length)
                    index = 0;
            }
        }

        return getColor;
    }

    function filterClass(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        var input = document.getElementsByTagName("input");
        
        for(var i = 0; i < input.length ; i++){
            if(input[i].checked)
                var filter = input[i].value;
        }

        for(var i = 0; i < div.length ; i++){
            div[i].style.display = "none";
        }

        colors = associateColor();

        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[0];
            var text = mySpan.getAttribute("class");
            if(filter == "" || filter == text){
                div[i].style.display = "";
                div[i].style.backgroundColor= colors.get(text);
            }
        }
    }

    function colorSubjects(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        colors = associateColor();

        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[0];
            var text = mySpan.getAttribute("class");
            div[i].style.backgroundColor= colors.get(text);
        }
    }
</script>
