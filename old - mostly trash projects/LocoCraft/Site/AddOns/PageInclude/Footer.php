<script>
    
    function Hide(){
        $("#Info").slideUp("fast");
    }
    
    $(document).ready(function(){
        $("#Footer").hover(function(){
            $("#Info").slideDown("fast");
        });
        $("#Info").mouseleave(function(){
            $("#Info").slideUp("fast");
        });
        Hide();
    });
</script>
<div class="UnderFooter" id="Info">
    This site us custom written by onno204.<br>
    For questions send me an email: webmaster@onno204.nl.eu.org<br>
    
    
</div>
<div class="Footer" id="Footer"> 
    ☛ ©LocoCraft Network - Minecraft server network - LocoCraft Network© ☚
</div>

