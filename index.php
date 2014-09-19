<?php
include("db.php");
?>

<html lang="en">
    <head>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script type="text/javascript">
            $(function () {
                var loginForm = $("#loginForm");
                var divContent = $("#content");
                var successMessage = $("#success");
                var errorMessage = $("#errorMessage");
                
                var usernameInput = $("#username");
                var passwordInput = $("#password");
                
                loginForm.submit(function(event) {
                    event.preventDefault();
                    
                    $.ajax({
                        type: "GET",
                        url: "./ajax.php",
                        dataType: "json",
                        data: {
                            type: "loginUser",
                            username: usernameInput.val(),
                            password: passwordInput.val()
                        },
                        success: function (json) {
                            if(json.error === 0)
                            {
                                divContent.hide();
                                successMessage.append("Hello, you are logged in " + json.userName + ".");
                            }

                            else
                            {
                                errorMessage.empty();
                                errorMessage.append(json.message);
                            }
                        },
                        error: function(e)
                        {
                            console.log(e);
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
        <div id="content">
            <form id="loginForm" method="post">
                <label>UserName :</label>
                <input id="username" name="username" placeholder="username" type="text" required >
                <label>Password :</label>
                <input id="password" name="password" placeholder="**********" type="password" required >
                <input name="submit" type="submit" value=" Login ">
            </form>
        </div>
        
        <div id="success"><?= (isset($_SESSION['username']) && $_SESSION['username'] != NULL ? '<h1>Welcome ' . $_SESSION['username'] . '</h1>' : ''); ?></div>
        
        <div id="errorMessage"></div>
    </body>
</html>