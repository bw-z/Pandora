<div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a> <a class="brand" href="#">Pandora</a>

                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li class="active"><a href="../home/">Home</a></li>

                        <li><a href="../new/">New Password</a></li>

                        
                    </ul>

                    <p class="navbar-text pull-right">Logged in as <?= $currentUser->username ?> 
                    &nbsp;&nbsp;&nbsp;<a href="../logout/">Logout</a></p>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>