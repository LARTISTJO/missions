
    $(window).scroll(function(){
        if ($(window).scrollTop()){
            $("nav").addClass("lightgreen");
            $(".nav-link").addClass("lightgreen");
        }
        else {
            $("nav").removeClass("lightgreen");
            $(".nav-link").removeClass("lightgreen");
        }
})