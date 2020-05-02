$(document).ready(function () {
        var slider= $(".list-slider");
        var listCount = slider.find('li');
        var prevBtn = $(this).find('.prev');
        var nextBtn = $(this).find('.next');
        var slideWidth=$('.list-slider > li:first').width();
        var sliderIterator = slideWidth;

        var mobile = $(window).width()>500 ? 2 : 1;
        var mobileWidth = $(window).width()>500 ? 0 : 1;
        if($(window).width()<500){
            slider.css({
                'transform': 'translate(' + 0 + 'px)'
            });
        }
        var i = 0;
        function slideRun() {
            if ((i+1) >= (listCount.length + mobileWidth) )
            {
                i = 0;
                if(!$(listCount[i-mobileWidth]).hasClass("full-opacity")){
                    $(listCount[i-mobileWidth]).addClass("full-opacity");
                }
                $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                sliderIterator = slideWidth;
                slider.css({
                    'transform': 'translate(' + sliderIterator + 'px)'
                });
            } else {
                sliderIterator = sliderIterator - slideWidth;
                i++;
                if(!$(listCount[i-mobileWidth]).hasClass("full-opacity")){
                    $(listCount[i-mobileWidth]).addClass("full-opacity");
                }
                $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                slider.css({
                    'transform': 'translate(' + (sliderIterator-(6*i*mobile)) + 'px)'
                });


            }
        }
        var myVar = setInterval(slideRun, 9000);
        $(".list-slider").hover(function () {
            window.clearTimeout(myVar);
        },function () {
            //on un hover
            myVar = setInterval(slideRun, 9000);
        });


        /// selected item /////
        $(".slider-list-item").click(function () {
            window.clearTimeout(myVar);

            sliderIterator = sliderIterator - ($(this).index() + slideWidth);
            i=$(this).index();
            $(this).addClass("full-opacity boder");
            $(this).siblings().removeClass("full-opacity");
            slider.css({
                'transform': 'translate(' + (sliderIterator-(6*i*mobile)) + 'px)'
            });
            myVar = setInterval(slideRun, 9000);
        });
        /// slider controler /////
        $(".slider-controler").click(function () {
            if($(this).attr("id")=="next-slider"){
                if ((i+1) >= (listCount.length +mobileWidth) )
                {
                    i = 0;
                    $(listCount[i-mobileWidth]).addClass("full-opacity");
                    $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                    sliderIterator = slideWidth;
                    slider.css({
                        'transform': 'translate(' + sliderIterator + 'px)'
                    });
                }
                else{
                    sliderIterator = sliderIterator - slideWidth;
                    i++;
                    $(listCount[i-mobileWidth]).addClass("full-opacity");
                    $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                    slider.css({
                        'transform': 'translate(' + (sliderIterator-(6*i*mobile)) + 'px)'
                    });
                    window.clearTimeout(myVar);
                    myVar = setInterval(slideRun, 9000);
                }
            }
            else if($(this).attr("id")=="pre-slider"){
                if(i != 0){
                    if (i <= (listCount.length - mobile) ) {
                        i--;
                        sliderIterator = sliderIterator + slideWidth;
                        $(listCount[i-mobileWidth]).addClass("full-opacity");
                        $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                        slider.css({
                            'transform': 'translate(' + (sliderIterator-(6*i*mobile)) + 'px)'
                        });
                        window.clearTimeout(myVar);
                        myVar = setInterval(slideRun, 9000);
                    }
                    else{
                        i = 0;
                        $(listCount[i-mobileWidth]).addClass("full-opacity");
                        $(listCount[i-mobileWidth]).siblings().removeClass("full-opacity");
                        sliderIterator = slideWidth;
                        slider.css({
                            'transform': 'translate(' + sliderIterator + 'px)'
                        });

                        window.clearTimeout(myVar);
                        myVar = setInterval(slideRun, 9000);
                    }
                }
                else {
                    slider.css({
                        'transform': 'translate(356px)'
                    });

                }


            }
        });
        wait(300);
        countIt();
        ////************counter interval*************//////

        function countIt() {
            var counters = $(".count");
            var countersQuantity = counters.length;
            var counter = [];

            for (var ii = 0; ii < countersQuantity; ii++) {
                counter[ii] = parseInt(counters[ii].innerHTML);
            }

            var count = function(start, value, id) {
                var localStart = start;
                var increment = value / 100;
                setInterval(function() {
                    if (localStart < value) {
                        localStart= localStart + increment;
                        counters[id].innerHTML = Math.round(localStart);
                    }
                }, 40);
            }

            for (j = 0; j < countersQuantity; j++) {
                count(0, counter[j], j);
            }

        }
        //wait 2 seconds and start counting
        function wait(ms){
            var start = new Date().getTime();
            var end = start;
            while(end < start + ms) {
                end = new Date().getTime();
            }
        }
        ////************counter interval*************//////
    });