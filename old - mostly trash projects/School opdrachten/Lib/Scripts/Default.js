/////////////////////////////
//  Site Loader
////////////////////////////

var ClearInter;
//More fancy loading
function SlideDown(){
    $("nav").slideDown(650).css("display", "inline-block");
    $(".content").slideDown(600).css("display", "block");
    clearInterval(ClearInter);
}

$(document).ready(function(){
    $(".voor").hover(function(){
        $(".tegen").css("width", "20vw");
        $(".voor").css("width", "70vw");
    });
    $(".tegen").hover(function(){
        $(".voor").css("width", "20vw");
        $(".tegen").css("width", "70vw");
    });
    $("li").hover(
        function(){
            $(this).children('div').slideDown(400);
        },function(){
            $(this).children('div').slideUp(300);
        }
    );
    
    
});
/*
 * 
 * 
    $(".voor").hover(function(){
        $(".tegen").animate({width: "20vw"});
        $(".voor").animate({width: "70vw"});
        
    });
    $(".tegen").hover(function(){
        $(".voor").css({width: "20vw"}, {speed: 10000});
        $(".tegen").animate({width: "70vw"}, {speed: 10000});
        
    });
 */