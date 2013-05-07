<?php include("_head.php"); ?>

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>


  </head>

  <body>

    <?php include("_menu.php"); ?>
    
    <div class="container">

      <form class="form-horizontal" method="post">
		  <div class="control-group">
		    <label class="control-label" for="itype">Title</label>
		    <div class="controls">
		      <input class="span4"  type="text" placeholder="" id="title">		      
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Username</label>
		    <div class="controls">
		      <input class="span4" type="text" placeholder="" id="username">		      
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Password</label>
		    <div class="controls">
		      <input class="span4" type="password" placeholder="" id="password">		      
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Notes</label>
		    <div class="controls">
		     	<textarea rows="5" id="notes"></textarea>	      
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">URL</label>
		    <div class="controls">
		      <input class="span4" type="text" placeholder="" id="url">		      
		    </div>
		  </div>

		  </div>
		  

		  <div class="form-actions">
				   <input type="button" class="btn btn-large btn-primary" onclick="newPassword()" value="Save Password">
				  </div>	
	</form>



      
          
		</div>
      <hr>

 

    </div> <!-- /container -->


  </body>
</html>

