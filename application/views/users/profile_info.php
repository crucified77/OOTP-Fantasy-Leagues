   	<script type="text/javascript" charset="UTF-8">
	$(document).ready(function(){	
		$('input[rel=inviteRespond]').click(function(){
			var params = this.id.split("|");
			document.location.href = '<?php echo($config['fantasy_web_root']); ?>user/inviteResponse/id/'+params[0]+'/ct/'+params[1]+'/ck/'+params[2];
		});
	});
	</script>
    <div id="subPage">
       	<div id="content">
           	<!-- BEGIN RIGHT COLUMN -->
           	<div id="metaColumn">
					<?php if ($loggedIn && $currUser == $profile->userId) { ?>
                   	<!-- LEAGUE INVITATIONS BOX -->
                    <?php if (isset($invites) && sizeof($invites) > 0) { ?>
                    <div class='textbox'>
                    <table cellpadding="0" cellspacing="0" border="0" style="width:325px;" class="dashboard">
                    <tr class='title'>
                        <td style="padding:3px">League Invitations</td>
                    </tr>
                    <tr>
                    	<td style="padding:12px; line-height:1.5;">
						<?php 
						foreach($invites as $invite) { 
							if (isset($invite['avatar']) && !empty($invite['avatar'])) { 
								$avatar = $invite['avatar'];
							} else {
								$avatar = DEFAULT_AVATAR;
							} // END if
							?>
							<img src="<?php echo(PATH_LEAGUES_AVATARS.$avatar) ?>" width="18" height="18" border="0" alt="avatar" title="avatar" align="absmiddle" />
							<b><?php echo(anchor('/league/info/'.$invite['league_id'],'<b>'.$invite['league_name'].'</b>')); ?></b><br />
                            Invite from: <?php echo($invite['username']); ?><br />
                            Sent On: <?php echo(date('m/d/Y h:m A',strtotime($invite['send_date ']))); ?><br />
                        	<input type='button' rel="inviteRespond" id="<?php echo($invite['id']); ?>|1|<?php echo($invite['ck']); ?>" class="button" value='Accept' style="float:left;margin-right:8px;" />
							<input type='button' rel="inviteRespond" id="<?php echo($invite['id']); ?>|-1|<?php echo($invite['ck']); ?>" class="button" value='Decline' style="float:left;margin-right:8px;" />
                        <div class="rule"></div>
                        <?php
						} // END if
						?></td>
                    </tr>
                    </table>
                    </div>
                    <?php
					} // END if
					?>
                    <!-- Tool Box -->
                    <div class='textbox'>
                    <table cellpadding="0" cellspacing="0" border="0" style="width:325px;" class="dashboard">
                    <tr class='title'>
                        <td style="padding:3px">My Options</td>
                    </tr>
                    <tr>
                    	<td style="padding:3px">
                        <ul class="iconmenu">
                        <li><?php echo anchor('/user/profile/edit','<img src="'.$config['fantasy_web_root'].'images/icons/notes_edit.png" width="48" height="48" border="0" />'); ?><br />
                        Edit My Profile</li>
                        <li><?php echo anchor('/user/avatar','<img src="'.$config['fantasy_web_root'].'images/icons/image_edit.png" width="48" height="48" border="0" />'); ?><br />
            			Change My Avatar</li>
                        <li><?php echo anchor('/search/leagues','<img src="'.$config['fantasy_web_root'].'images/icons/search.png" width="48" height="48" border="0" />'); ?><br />
            			Find a team</li><br clear="all" />
						<?php 
						if ($config['users_create_leagues'] == 1) { ?>
                        <li><?php echo anchor('/user/createLeague','<img src="'.$config['fantasy_web_root'].'images/icons/window_add.png" width="48" height="48" border="0" />'); ?><br />
            			Create a new League</li>
                        <?php } ?>
						</ul></td>
                    </tr>
                    </table>
                    </div>
                    <?php } ?>
                    
                    
                   	
           		</div>
               	<!-- BEGIN MAIN COLUMN -->
                <div id="detailColumn">
                    <h1><?php 
					if (isset($profile->avatar) && !empty($profile->avatar)) { 
						$avatar = $profile->avatar;
					} else {
						$avatar = DEFAULT_AVATAR;
					} 
					?>
                    <img src="<?php echo(PATH_USERS_AVATARS.$avatar) ?>" width="50" height="50" border="0" alt="avatar" title="avatar" align="absmiddle" />
					<?php if (isset($profile->firstName) && isset($profile->lastName)) {
						echo($profile->firstName." ".$profile->lastName); 
					} else {
						echo("No Name Provided"); 
					}?></h1>
					<b>Nickname:</b> <?php if (isset($profile->nickName)) { echo($profile->nickName); } ?><br />
                    <br />
                    <label><strong>Title:</strong></label>
					<?php echo((!empty($profile->title) ? $profile->title : "No Title provided.")); ?>
                    <p />&nbsp;&nbsp;
                    <label><strong>Bio:</strong></label>
					<?php echo((!empty($profile->bio) ? $profile->bio : "No Bio provided. ".anchor('/user/profile/edit','Add a bio').".")); ?>
                    <br /><br />  
                    <b>Joined:</b> <?php print(date('m/d/Y',strtotime($dateCreated))); ?><br />    
                    <br />     
                    <b>Last Updated:</b> <?php print(date('m/d/Y',strtotime($dateModified))); ?><br />    
                    <br />                
                  	<h3>Fantasy Teams</h3>
                   	<div class='textbox'>
                   	<?php  if (isset($userTeams) && sizeof($userTeams) > 0) {
					$teamList = array('rot'=>array(),'h2h'=>array());
					if (sizeof($userTeams) > 0) { 
						foreach($userTeams as $data) { 
							$type = "";
							if ($data['league_type'] == LEAGUE_SCORING_HEADTOHEAD) {
								$type = "h2h";
							} else {
								$type = "rot";
							}
							array_push($teamList[$type], $data);	
						}
					} 
					foreach($teamList as $type => $teams) {
						if (sizeof($teams) > 0) {
					?>
                    <table style="margin:6px" class="sortable" cellpadding="5" cellspacing="0" border="0" width="560px">
                    <tr class='title'>
                    	<?php 
						$cols = 7;
						if ($loggedIn && $currUser == $profile->userId) { $cols = 8; } ?>
                        <td colspan='<?php print($cols); ?>' class='lhl'><?php print((($type == 'rot') ? 'Rotisserie' : "Head to Head")." Leagues"); ?></td>
                    </tr>
                    <tr class='headline'>
                        <td class='hsc2_c' colspan="2">Team</td>
                        <td class='hsc2_c'>League</td>
                        <?php
						if ($type == 'rot') { ?>
                        <td class='hsc2_c'>Total</td>
                        <td class='hsc2_c'>Rank</td>
                        <?php } else { ?>
                        <td class='hsc2_c'>W</td>
                        <td class='hsc2_c'>L</td>
                        <td class='hsc2_c'>%</td>
                        <td class='hsc2_c'>GB</td>
                        <?php } ?>
                        <?php if ($loggedIn && $currUser == $profile->userId) { ?>
                        <td class='hsc2_c'>Options</td>
                        <?php } ?>
                    </tr>
                    
                    <?php 
					foreach($teams as $data) {
						$rowcount = 0;
						$leadW = 0;
						$leadG = 0;
						if (($rowcount %2) == 0) { $color = "#EAEAEA"; } else { $color = "#FFFFFF"; } 
						?>
					<tr style="background-color:<?php echo($color); ?>">
						<td class='hsc2_l'>
                        <?php 
						if (isset($data['avatar']) && !empty($data['avatar'])) { 
							$avatar = $data['avatar'];
						} else {
							$avatar = DEFAULT_AVATAR;
						}
						?>
						<img src="<?php echo(PATH_TEAMS_AVATARS.$avatar); ?>" width="24" height="24" border="0" align="absmiddle" />
						</td>
                        <td class='hsc2_r'><?php echo(anchor('/team/info/'.$data['id'],$data['teamname']." ".$data['teamnick'])); ?></td>
						<td class='hsc2_r'><?php echo(anchor('/league/info/'.$data['league_id'],$data['league_name'])); ?></td>
						<?php
						if ($type == 'rot') { ?>
                        <td class='hsc2_l' align="right"><?php echo($data['total']); ?></td>
						<td class='hsc2_l' align="right"><?php ?></td>
						<?php } else { ?>
                        <td class='hsc2_r' align="right"><?php echo($data['w']); ?></td>
						<td class='hsc2_r' align="right"><?php echo($data['l']); ?></td>
						<td class='hsc2_r' align="right"><?php echo(sprintf("%.3f",$data['pct'])); ?></td>
						<td class='hsc2_r' align="right"><?php echo($data['gb']); ?></td>
                        <?php } ?>
                        <?php if ($loggedIn && $currUser == $profile->userId) { ?>
                        <td class='hsc2_l'><?php echo anchor('/league/select/id/'.$data['league_id'].'/team_id/'.$data['id'],'Select'); ?></td>
                        <?php } ?>
					</tr>
                    <?php if (isset($userDrafts) && isset($userDrafts[$data['league_id']])) { 
						$draftInfo = $userDrafts[$data['league_id']];
						if ($draftInfo['draftStatus'] > 0 && $draftInfo['draftStatus'] < 5) {
					?>
                    <tr style="background-color:#FFC">
						<td class='hsc2_l' colspan="3">
                        <span style="color:#c00;font-weight:bold;">
                        <?php 
							if ($draftInfo['draftStatus'] < 2) {
								if (isset($draftInfo['draftDate']) && $draftInfo['draftDate'] != EMPTY_DATE_TIME_STR) {
									$statusMess = 'Your league draft begins '.date('m/d/Y',strtotime($draftInfo['draftDate']))." at ".date('h:i A',strtotime($draftInfo['draftDate']));
								} else {
									$statusMess = 'Your league draft is coming up soon.';
								}
								$statusMess .= '<br /><br />'.anchor('/team/info/'.$draftInfo['team_id'],$draftInfo['teamname']." ".$draftInfo['teamnick']).' is the first team to pick.';
							} else if ($draftInfo['draftStatus'] >= 2 && $draftInfo['draftStatus'] < 5) {
								$statusMess = 'Your league is currently drafting.</span><br /><br /> '.anchor('/team/info/'.$draftInfo['team_id'],$draftInfo['teamname']." ".$draftInfo['teamnick']).' is the next team to pick.';
							} // END if ($draftInfo['draftStatus'] > 0
							echo($statusMess); ?>
							</td>
							<td class='hsc2_l' colspan="5"> <?php
							$outText = "Set up your draft list or review the player pool.";
							if ($draftInfo['draftStatus'] >= 2 && $draftInfo['draftStatus'] < 5) {
								if ($draftInfo['team_id'] == $data['id']) { 
									$outText = "Pick now!";
								} else {
									echo "<strong>In the meantime:</strong><br /><br />";
								}
							}
							echo anchor('/draft/selection/league_id/'.$data['league_id'].'/team_id/'.$data['id'],$outText,array('style'=>'font-weight:bold;')); 
						} // END if ($draftInfo['draftStatus'] > 0 
					} // if (isset($userDrafts)
					?></td>
					</tr>
						<?php
						$rowcount++;
						} // END for
					} // END if (sizeof($userTeams)
					}
					?>
                    </table>
                    </div>
					<?php } else { ?>
					<table style="margin:6px" class="sortable" cellpadding="5" cellspacing="0" border="0" width="560px">
                    <tr class='title'>
                        <td colspan='8' class='lhl'>No Teams Found</td>
                    </tr>
					<tr>
						<td align="center">No teams were found.</td>
					</tr>
					</table>
					</div>
					<?php } ?>
                    <br clear="all" class="clear" />
                    </div>
                    </div>
	</div>