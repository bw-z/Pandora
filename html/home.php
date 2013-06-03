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
    
    	<?php if (isset($_REQUEST['error'])) { ?>
	        <div class="alert alert-error">
	            An unexpected error has occurred... please try again or contact an administrator.
	        </div>
	     <?php } ?>
	     
	     
        <h2>My Passwords</h2>

        <div class="row">
            <p></p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <td></td>

                        <td>
                            <h4>Username</h4>
                        </td>

                        <td>
                            <h4>Password</h4>
                        </td>

                        <td></td>

                        <td>
                            <h4>Notes</h4>
                        </td>

                        <td>
                            <h4>URL</h4>
                        </td>
                        <!--<td></td>-->

                        <td>
                            <h4>Last Updated</h4>
                        </td>

                        <td></td>
                    </tr>
                </thead>

                <tbody>
                    <?php

                              foreach($plist as $i) {
                      
                              ?>

                    <tr>
                        <td>
                            <script type="text/javascript">
	                            document.write(hsc(de("<?=$i['title']?>")));
                            </script>
                        </td>

                        <td>
                            <script type="text/javascript">
	                            document.write(hsc(de("<?=$i['username']?>")));
                            </script>
                        </td>

                        <td id="pass<?=$i['id']?>">
                            <script type="text/javascript">
	                            for (var j = 0; j < de("<?=$i['password']?>").length; j++) {
	                            	document.write("*");
	                            }
                            </script>
                        </td>

                        <td>
                            <!--
            <a class="btn" href="#" id="popCopy<?=$i['id']?>" data-trigger="hover" data-html="true" rel="popover" data-placement="left" data-content="Copy Password to Clipboard" ><i class="icon-plus" ></i></a> 
                <script>  
                    $(function ()  
                    { $("#popCopy<?=$i['id']?>").popover(); 
                    });  
                </script>
            -->
                            <!--
                script>document.write('"' + hsc(de("<?=$i['password']?>")) + '"');</script>-->
                            
                            <a class="btn" href="#" id="popPass<?=$i['id']?>" data-trigger="hover" data-html="true" rel="popover" data-placement="left" data-content="" onclick="showPass<?=$i['id']?>()"><i class="icon-eye-open" ></i></a> 
                            <script type="text/javascript">
		                        //Function for popup text
	                            $(function ()  
	                            { $("#popPass<?=$i['id']?>").popover(); 
	                            });
	                            
	                            //Hide the password by default
	                            var show<?=$i['id']?> = 0
	                            // reveil the password
	                            function showPass<?=$i['id']?>() {
		                            
	                            if (show<?=$i['id']?> == 0) {
	                                pass<?=$i['id']?>.innerText = hsc(de("<?=$i['password']?>"));
	                                show<?=$i['id']?> = 1;
	                            } else {
	                            	// mask the password with *s
	                                var mask = ""
	                                for (var j = 0; j < de("<?=$i['password']?>").length; j++) {
	                                    mask = mask + "*";
	                                }
	                                pass<?=$i['id']?>.innerText = mask;
	                                show<?=$i['id']?> = 0;
	                            }
	
	                                        
	                            }

                            </script>
                        </td>

                        <td>
                            <script type="text/javascript">
	                            document.write(hsc(de("<?=$i['notes']?>")));
                            </script>
                        </td>

                        <td>
                            <script type="text/javascript">
	                            document.write(hsc(de("<?=$i['url']?>")));
                            </script>
                        </td>
                        <!--
			            <td><a class="btn" href="<?=$i['url']?>" target="_new" id="popGo<?=$i['id']?>" data-trigger="hover" data-html="true" rel="popover" data-placement="left" data-content="Go to URL" ><i class="icon-circle-arrow-right" ></i></a> 
			                <script>  
			                    $(function ()  
			                    { $("#popGo<?=$i['id']?>").popover(); 
			                    });  
			                </script>
			            </td>
			            -->

                        <td><?=htmlspecialchars(date("Y-m-d", $i['timestamp']))?>
                        </td>

                        <td>
                            <div class="btn-group"></div>
                        </td><!--
			            <td><a class="btn" href="../view/<?=($i['id'])?>">View or Edit &raquo;</a></td>
			            -->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>

        <footer>
            <p></p>
        </footer>
    </div><!-- /container -->


</body>
</html>
