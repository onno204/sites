
$(document).ready(function(){
    CreatePhoneMenu();
});

var Items;
function DisplayNav(){
    var next = ($(".NavContent").attr("shown") === "1") ? "0" : "1" ;
    $(".NavContent").attr("shown", next);
    $("nav").toggleClass("NavX");
    $(".NavContent").slideToggle(500);
}

function CreatePhoneMenu(){
    $("#NavPic").remove();
    Items = $("nav").html();
    Items = Items.replace(/<a/g, "<br><br><a");
    $("nav").html(""
    + "<center id=\"NavButton\" >"
    + "<div class=\"navbar1\"></div>"
    + "<div class=\"navbar2\"></div>"
    + "<div class=\"navbar3\"></div>"
    + "</center>"
    + "");
    $("nav").before(""
    + "<div class=\"NavContent\">"
    + Items
    + "</div>");
    $("#NavButton").attr("onclick", "DisplayNav();");
    $("#NavButton").css({cursor: "pointer"});
    $("nav").css({width: "50px"});
}
