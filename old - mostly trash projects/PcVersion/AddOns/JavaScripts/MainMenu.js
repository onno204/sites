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
    
    function SetLocation(LocationID){
        LocationID1 = LocationID.split("/");
        document.title = "onno204 - " + LocationID1[LocationID1.length-1];
    }
    
    function GotoURL(){
        if (window.location.hash !== null){
            ShowLoading();
            Options = window.location.hash.replace("#", "").split("?");
            PHP = Options[1];
            if(PHP == null){ PHP = ""; }
            Link = Options[0];
            SetLocation(Link);
            Path1 = Link + ".php";
            path2 = "/PcVersion" + Path1 + "?" + PHP;
            $.ajax({
                url: path2,
                success: function(data){
                    $("#ContentBox").load(path2);
                    HideLoading();
                },
                error: function(){ 
                    ErrorPath = "Default/Error.php";
                    $("#ContentBox").load(ErrorPath);
                    HideLoading();
                }
            });
            HideLoading();
        }
    }
    
    function GoToMyID(ID){
        ShowLoading();
            Options = ID.replace("#", "").split("?");
            PHP = Options[1];
            if(PHP == null){ PHP = ""; }
            Link = Options[0];
            SetLocation(Link);
            Path1 = Link + ".php";
            path2 = location.protocol+'//'+location.host+location.pathname+(location.search?location.search:"")+ Path1 + "?" + PHP;
            $.ajax({
                url: path2,
                success: function(data){
                    $("#ContentBox").load(path2);
                    HideLoading();
                },
                error: function(){ 
                    ErrorPath = "Default/Error.php";
                    $("#ContentBox").load(ErrorPath);
                    HideLoading();
                }
            });
            HideLoading();
    }
    
    function GotoNoLoadCheck(){
        ShowLoading(); 
        if (window.location.hash != null){
            var Path = window.location.hash;
            Path = Path.replace("#", "");
            Path1 = "/PcVersion" + Path + ".php";
            $("#ContentBox").load(Path1);
            HideLoading();
        }
        HideLoading();
    }
    
    function HideLoading(){
        $(".ImgOverlay").slideUp(500);
    }
    function ShowLoading(){
        $(".ImgOverlay").slideDown(500);
    }