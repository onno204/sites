<script>
function Enter() {
    survey.style.display = "none";
    
    if (!(survey.value==="")){
        thank.style.display = "inline";
        return false;
    }
    else {
       thank.style.display = "none";
        return true;
    }
}
</script>

<div id="right">
    <div id="thank" style=" display: none">
        Thank you, your message has been sent.
    </div>
    <input id="survey" type="text" > </input>
    <input type="submit" value="Contact Us!" onclick="Enter(); this.style.display = 'none'; "/>
</div>