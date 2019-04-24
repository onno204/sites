<?php
$config = include $_SERVER['DOCUMENT_ROOT'] . "/Site" . '/AddOns/PhP/Config.php';
?>
<div class="Topper">
    <a class="Title" href="<?php echo $config->MainPath ?>/">
    <br>
    LocoCraft
    </a>
    <ul class="Menu">
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/">Home</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/Login/">Login</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/BanList/">BanList</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->RootSite ?>/Forums/">Forums</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/Dynmap/">Dynmap</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/ServerStatus/">ServerStatus</a></li>
        <li class="Menu" ><a class="Menu" href="<?php echo $config->MainPath ?>/PlayerInfo/">Players</a></li>
    </ul> 
</div>

