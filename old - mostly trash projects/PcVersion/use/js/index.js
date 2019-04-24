function load_home() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/home.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "Home Page";
}function load_About() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/about.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "About SNova play's";
}function load_Ranks() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/ranks.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "Ranks";
}function load_chat() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/chat.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "Chat";
}function load_Questions() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/questions.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "questions";
}function load_saveinfo() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/saveinfo.php" style="width:100%; height: 100%;" ></object>';
    document.getElementById("selectedtext").innerHTML = "Save Info";
}function codeAddress() {
    document.getElementById("section").innerHTML = '<object type="text/html" data="use/home.php" style="width:100%; height: 100%;" ></object>';}
window.onload = codeAddress;
