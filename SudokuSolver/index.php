 <head>
    <!-- Top Info -->
    <title>Sudoku Solver</title>
    <link rel="icon" href="Lib/Pictures/Smileys/100x100.png" type="image/x-icon">

    <!-- Search Engine info -->
    <meta charset="UTF-8" />
    <meta name="keywords" content="Remote,Control,externalmanagement,hack,Loginrequired" />
    <meta name="description" content="Remote control program custom written and created" />
    <meta name="author" content="onno204" />
    <base href="127.0.0.1" target="" />

    <!-- Scripts -->
    <script src="Lib/JQuery.js"></script>
    <script src="Lib/Main.js"></script>
    <link rel="stylesheet" type="text/css" href="Lib/style.css">
    <link rel="stylesheet" type="text/css" href="Lib/Blocks.css">
    
</head>
<body onresize="CenterScreen();">
    <output onclick="$(this).slideUp(500);"></output>
    <info onmouseover="$('info').fadeOut(100);">*</info>
    <explain>
        <div>
            <p>How it works:</p>
            <p>Left-Right / Up-Down</p>
            <p>Per item it looks in the row and collums for possible numbers. Compare it against the 3x3 cage numbers. And Voilá</p>
        </div>
    </explain>
    <numbers>
        <div>
            <h1>Numbers:</h1><br>
            <span><p>9: </p><label id="N9">0</label></span>
            <span><p>8: </p><label id="N8">0</label></span>
            <span><p>7: </p><label id="N7">0</label></span>
            <span><p>6: </p><label id="N6">0</label></span>
            <span><p>5: </p><label id="N5">0</label></span>
            <span><p>4: </p><label id="N4">0</label></span>
            <span><p>3: </p><label id="N3">0</label></span>
            <span><p>2: </p><label id="N2">0</label></span>
            <span><p>1: </p><label id="N1">0</label></span>
            <span><p>Empty:</p><label id="N0">81</label></span>
        </div>
    </numbers>
    <input class="SaveBtn Button" type='submit' onclick="save()" value="save"/>
    <input class="LoadBtn Button" type='submit' onclick="load()" value="load"/>
    <input class="SolveBtn Button" type='submit' onclick="Execute()" value="Solve"/>
    <input class="LoopTimes" type='number' min='1' max='90' value="1" />
    <p class="LoopTimesText">How many loops?</p>
    <div class="SaveName">
        <select id="SaveName">
            <option value="Reset">Reset</option>
            <option value="Save1">Save1</option>
            <option value="Save2">Save2</option>
            <option value="Save3">Save3</option>
            <option value="Save4">Save4</option>
            <option value="Save5">Save5</option>
            <option value="Save6">Save6</option>
            <option value="Save7">Save7</option>
            <option value="Save8">Save8</option>
        </select>
    </div>
    <div class="prog">
        <div class="ProgressBarr"> <div class="Progress"> <div class="ProgressProcent">0%</div> </div> </div>
        <p>Filled amount</p>
    </div>
    
    
    <?php 
        for ($x = 1; $x <= 9; $x++) {
            for ($y = 1; $y <= 9; $y++) {
                echo "<input class='t$x-$y input' possible=\"0\" oninput=\"OnChange(this);\" onfocus=\"OnFocus(this);\" onmouseover=\"HoverInput(this);\" type='number' maxlength='1' min='0' max='9' />";
            }
        } 
    ?>
    <input class="LineBreak LineBreak3" type='number' disabled/>
    <input class="LineBreak LineBreak6" type='number' disabled/>
    
    <input class="LineBreak LineBreak633" type='number' disabled/>
    <input class="LineBreak LineBreak643" type='number' disabled/>
    <input class="LineBreak LineBreak653" type='number' disabled/>
   
    <input class="LineBreak LineBreak636" type='number' disabled/>
    <input class="LineBreak LineBreak646" type='number' disabled/>
    <input class="LineBreak LineBreak656" type='number' disabled/>
</body>