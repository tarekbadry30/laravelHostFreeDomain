$(document).ready(function () {
        var slider= $(".list-slider");
        var listCount = slider.find('li');
        var prevBtn = $(this).find('.prev');
        var nextBtn = $(this).find('.next');

        var i = 0;
        if($(window).width()<500){
            for(var interv=1;interv<=listCount;interv++){
                $('.list-slider > li:nth-of-type('+interv+')').width($(window).width());
            }

        }
        var itemWidth=$('.list-slider > li:first').width();
        var slideredWidth=itemWidth;
        function slideRun() {
        //check if full item slided retun to start
        if (i >= listCount.length) {
            i = 0;
            slideredWidth = itemWidth;
            if(!$(listCount[i]).hasClass("full-opacity")){
                $(listCount[i]).addClass("full-opacity");
            }
            $(listCount[i]).siblings().removeClass("full-opacity");
            slider.css({
                'transform': 'translate('+slideredWidth+'px)'
            });
        } else {
            i++;
            console.log(slideredWidth);
            if(!$(listCount[i]).hasClass("full-opacity")){
                $(listCount[i]).addClass("full-opacity");
            }
            $(listCount[i]).siblings().removeClass("full-opacity");
            slideredWidth = (itemWidth * i)-itemWidth;

            slider.css({
                'transform': 'translate(-' + slideredWidth + 'px)'
            });

        }
    }

        var myVar = setInterval(slideRun, 6000);

        $(".list-slider").hover(function () {
            window.clearTimeout(myVar);
        },function () {
            //on un hover
            window.clearTimeout(myVar);

            myVar = setInterval(slideRun, 6000);
        });


        /// selected item /////
        $(".slider-list-item").click(function () {
            window.clearTimeout(myVar);

            i=$(this).index();
            slideredWidth = (itemWidth * i)-itemWidth;

            $(this).addClass("full-opacity ");
            $(this).siblings().removeClass("full-opacity");
            slider.css({
                'transform': 'translate(-' + slideredWidth + 'px)'
            });
            myVar = setInterval(slideRun, 6000);
        });
        /// slider controler /////
        $(".slider-controler").click(function () {

        if($(this).attr("id")=="next-slider"){
            window.clearTimeout(myVar);

            slideRun();
            myVar = setInterval(slideRun, 6000);
        }
        else if($(this).attr("id")=="pre-slider"){
            window.clearTimeout(myVar);
            console.log('<<pre '+slideredWidth);
            if(i > 0 && i<=listCount.length){
                    i--;
                    if(!$(listCount[i]).hasClass("full-opacity")){
                        $(listCount[i]).addClass("full-opacity");
                    }
                    $(listCount[i]).siblings().removeClass("full-opacity");
                    slideredWidth = (itemWidth * i)-itemWidth;
                    slider.css({
                        'transform': 'translate(-' + slideredWidth + 'px)'
                    });
                console.log('after >>'+slideredWidth);


                myVar = setInterval(slideRun, 6000);
            }
            else{
                    i = 0;
                    slideRun();
                    myVar = setInterval(slideRun, 6000);

            }


        }
    });
        ////************counter interval*************//////
    });
