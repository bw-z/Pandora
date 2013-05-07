<?php include("_head.php"); ?>

    <style type="text/css">
body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

</head>

<body>
    <div class="container">
        <?php if (isset($_REQUEST['bad'])) { ?>

        <div class="alert alert-error">
            Invalid Username and Password combination
        </div><?php } ?><?php if (isset($_REQUEST['done'])) { ?>

        <div class="alert alert-error">
            Account created please enter your details again to login
        </div><?php } ?>

        <form class="form-signin" method="post">
            <h2 class="form-signin-heading" style="font-size: 16px;">Please sign in or create a new account</h2><input type="text" class="input-block-level" placeholder="user" name="user" id="user"> <input type="password" class="input-block-level" placeholder="password" name="password" id="password"> <input type="button" class="btn btn-large btn-primary" onclick="userLogin(document.getElementById('user').value, document.getElementById('password').value)" value="Go">
        </form>
    </div><!-- /container -->
</body>
</html>
