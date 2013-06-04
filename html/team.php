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

      <form class="form-horizontal" method="post" action="../post/team.php?a=<? if ($showteam) { ?>save<? } else { ?>new<? } ?>">
		  
		  <? if ($showteam == 0) { ?>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Team Name</label>
		    <div class="controls">
		      <input class="span4"  type="text" value="<? if ($showteam) { echo $t->teamName; } ?>" id="team_name" name="team_name">		      
		    </div>
		  </div>
		  
		  <? } else { ?>
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Team Name</label>
		    <div class="controls">
		      <?=$t->teamName?>	      
		    </div>
		  </div>
		  
		  <input type="hidden" name="teamid" value="<?=$t->getID()?>">
		  
		  <div class="control-group">
		    <label class="control-label" for="itype">Team Members</label>
		    <div class="controls">
		    	<ul>
		    	<? foreach($members as $m) { ?>
		    		<li><?= strtoupper($m['lastname']) . ", " . ucfirst($m['firstname']) . " (" . $m['username'] . ")"?>
		    			<? if ($m['userid'] == $t->getAdmin()) { ?>
		    				(Admin)
		    			<? } else { ?> 
		    				(<a href="../post/team.php?a=remove&teamid=<?=$t->getID()?>&userid=<?=$m['userid']?>">Remove</a>)
		    			<? } ?>
		    			
		    			</li>
		    	<? } ?>
		    	</ul>
		      <input class="span4"  type="text" placeholder="add team member" name="add_member" id="add_member" data-provide="typeahead" autocomplete="off">
		      <script type="text/javascript">
			      $(document).ready(function() {
				    $("#add_member").typeahead({
				        minLength: 3,
				        source: function(query, process) {
				            $.post('../post/user_search.php', { q: query, limit: 8 }, function(data) {
				                process(JSON.parse(data));
				            });
				        },
				        updater: function(obj) { 
				        	var username = obj.substring(obj.indexOf("(") + 1, obj.length - 1);
				        	document.location = "../post/team.php?a=save&teamid=<?=$t->getID()?>&add_member=" + encodeURIComponent(username);
				        }
				    });
				});
		      </script>
		    </div>
		  </div>
		  <? } ?>
		 
		  <div class="form-actions">
				   <input type="submit" class="btn btn-large btn-primary"  value="<? if ($showteam) { ?>Save Team<? } else { ?>Create Team<? } ?>">
				  </div>	
	</form>
     
	</div>
  <hr>

 

    </div> <!-- /container -->


  </body>
</html>

