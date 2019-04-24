function SelectProfileNext(Username){
    if(Username === null){
        Username = document.getElementById("username").value;
    }
    document.cookie = "username=" + Username;
    GoToMyID('#/Profile/ViewProfile');
}