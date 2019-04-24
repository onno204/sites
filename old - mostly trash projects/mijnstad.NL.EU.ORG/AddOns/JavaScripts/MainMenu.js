    function ClearMenus123(){
        $("#HeaderButton1Content").slideUp("fast");
        $("#HeaderButton2Content").slideUp("fast");
        $("#HeaderButton3Content").slideUp("fast");
        $("#HeaderButton4Content").slideUp("fast");
        ClearSubMenus123();
    }
    function ClearSubMenus123(){
        $("#Header2SubButton1ContentShow").slideUp("fast");
        $("#Header2SubButton2ContentShow").slideUp("fast");
        $("#Header2SubButton3ContentShow").slideUp("fast");
    }
    
    function GotoURL2(){
        ShowLoading();
        ID = window.location.hash;
        if(ID.indexOf("#")){
            console.log("No Option found.");
            HideLoading();
            return;
        }
        Options = ID.replace("#", "").split("?");
        PHP = Options[1];
        if(PHP === null){ PHP = ""; }
        Link = Options[0];
        Path1 = "" + Link + "index.php";
        path2 = Path1 + "?" + PHP;
        $("#ContentBox").load(path2);
        ScrollToContent();
        HideLoading();
    }
    function GoToMyID(ID){
        ShowLoading(); 
        Options = ID.replace("#", "").split("?");
        PHP = Options[1];
        if(PHP === null){ PHP = ""; }
        Link = Options[0];
        Path1 = location.protocol+'//'+location.host+location.pathname+(location.search?location.search:"")+"" + Link + "index.php";
        path2 = Path1 + "?" + PHP;
        $.ajax({
            url: path2,
            success: function(data){
                $("#ContentBox").load(path2);
                ScrollToContent();
                HideLoading();
            },
            error: function(){ 
                ErrorPath = "Default/Error.php";
                $("#ContentBox").load(ErrorPath);
                ScrollToContent();
                HideLoading();
            }
        });
    }
    
    function ScrollToContent(){
        $("#ContentBox").slideUp(1000);
        $("#ContentBox").slideDown(500);
    }
    
    function HideLoading(){
        $(".ImgOverlay").slideUp(500);
    }
    function ShowLoading(){
        $(".ImgOverlay").slideDown(500);
    }
    
    
    
    function GotoNoLoadCheck(){
        ShowLoading(); 
        if (window.location.hash != null){
            var Path = window.location.hash;
            Path = Path.replace("#", "");
            Path1 = "" + Path + "index.php";
            $("#ContentBox").load(Path1);
            HideLoading();
        }
        HideLoading();
    }