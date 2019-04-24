<script>

$(document).ready(function(){
    $("#UnlimitedLoader").click(function(){
        $("#LittleProjectsInfoTitle").text("Unlimited Loading Screen");
        $("#LittleProjectsInfo").text("This Is nothing usefull, u can just see my Loading screen rotating!");
        $("#LittleProjectsInfoExecute").attr("onclick","InfinitLoadingScreen()");
    });
    $("#SchoolProjects").click(function(){
        $("#LittleProjectsInfoTitle").text("SchoolProjects");
        $("#LittleProjectsInfo").text("This takes u to my school project page.");
        $("#LittleProjectsInfoExecute").attr("onclick","GoToSchoolPage()");
    });
    
});
</script>



<div class="LittleProjectContainer" id="LittleProjectContainer">
    <div class="LittleProjectsTitle" id ="LittleProjectsTitle">This are my little projects.<br>Click on one to see the information on the right!</div>
    <div class="LittleProjectsInfoTitle" id="LittleProjectsInfoTitle">Nothing selected</div>
    <div class="LittleProjectsInfo" id="LittleProjectsInfo">
        Select an option on the left side of the screen!
    </div>
    <div class="LittleProjectsInfoExecute" id="LittleProjectsInfoExecute" onclick="alert('Nothing selected!')">Execute Selected Project</div>
    <ul class="LittleProjectsList">
        <li id="SchoolProjects">SchoolProjects.</li>
        <li id="UnlimitedLoader">Unlimited Loading screen.</li>
        <li>Nothing</li>
    </ul>
</div>