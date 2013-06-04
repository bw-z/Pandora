<?php 
// used to sync paswords for all members of a group 
	// check all groups this user is a member of 
	$p = new Password($currentUser->userid, $db);
	$password_list = $p->getTeamPasswordList();
	
	foreach($password_list as $team) {
		
		// exclude the users private pasword list
		if ($team['groupid'] != 0) {
			// load the team details and user list
			$t = new Team($currentUser->userid, $db, $team['groupid']);
			$tmembers = $t->getUsers();
			
			// check each password
			foreach($team['password_list'] as $password) {
				// check each password
				foreach ($tmembers as $other_user) {
					// check to see if this user has an up to date version of this password
					// if not the password will be decryted using thsi users details then
					// encrypted with the recipients details and saved under their account
					if (!$p->checkSID($other_user['userid'], $password['suid'])) { 
						?>
						<script type="text/javascript">
							newPasswordSend("<?=$other_user['userid']?>", "<?=$other_user['username']?>", de("<?=$password['title']?>") , de("<?=$password['url']?>"), de("<?=$password['username']?>"), de("<?=$password['password']?>"), de("<?=$password['notes']?>"), "<?=$password['suid']?>", "<?=$team['groupid']?>");
					    </script>
						<?php
					}	
				}
			}
		}
	}
		
