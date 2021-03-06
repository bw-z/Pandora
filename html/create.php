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

        <form class="form-signin" method="post">
            <h2 class="form-signin-heading" style="font-size: 16px;">Create a new account</h2>
            
            <input type="text" class="input-block-level" placeholder="username" name="user" id="user"> 
            
            <input type="password" class="input-block-level" placeholder="password" name="password" id="password"> 
            
            <input type="password" class="input-block-level" placeholder="confirm password" name="confirm" id="confirm"> 
            
            <input type="text" class="input-block-level" placeholder="first name" name="first" id="first"> 
            
            <input type="text" class="input-block-level" placeholder="last name" name="last" id="last"> 
            
            <input type="text" class="input-block-level" placeholder="email address" name="email" id="email"> 
            
            <input type="button" class="btn btn-large btn-primary" 
            onclick="userCreateLocal()" value="Create Account">
        </form>
    </div><!-- /container -->
</body>
</html>
