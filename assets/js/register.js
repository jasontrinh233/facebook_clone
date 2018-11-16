$(document).ready(function() {
    
    //Click "signup", hide login and show signup form
    $("#signup").click(function() {
        $("#first").slideUp("slow", function() {
            $("#second").slideDown("slow");
        });
    });

    //Click "login", hide signup and show login form
    $("#signin").click(function() {
        $("#second").slideUp("slow", function() {
            $("#first").slideDown("slow");
        });
    });
    
});