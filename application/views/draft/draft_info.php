<style>
	input, select, label {
		float:none;
		margin:none;
		min-width:none;
		display:inline;
	}
	.dash {
		width:auto;
		padding: 1px;
		display:inline-block;
		color: black;
	}
	.dash .digit {
		font: bold 1.10em Arial;
		font-weight: bold;
		float: left;
		width: 16px;
		text-align: center;
		position: relative;
	}
	</style>
    <link media="screen" rel="stylesheet" href="<?php echo($config['fantasy_web_root']); ?>css/colorbox.css" />
	<script src="<?php echo($config['fantasy_web_root']); ?>js/jquery.colorbox.js"></script>
	<script type="text/javascript" src="<?php echo($config['fantasy_web_root']); ?>js/jquery.lwtCountdown-1.0.js"></script>
	<script type="text/javascript" charset="UTF-8">
	var counterActiveHTML = 'Refresh in: ';
	counterActiveHTML += '<div class="dash minutes_dash">';
	counterActiveHTML += '<div class="digit">0</div>&nbsp;<div class="digit">0</div>';
	counterActiveHTML += '</div> minutes, ';
	counterActiveHTML += '<div class="dash seconds_dash">';
	counterActiveHTML += '<div class="digit">0</div>&nbsp;<div class="digit">0</div>';
	counterActiveHTML += '</div> seconds';
	var labelEnableHTML = 'Enable';
	var labelDisableHTML = 'Disable';
	var theMinutes = 0;
	var theSeconds = 0;
	$(document).ready(function(){
		$('a[rel=makePick]').live('click',function (e) {					   
			e.preventDefault();
			openDialog(e, 'manualForm', this.id.split("|"));
		});	
		$('a[rel=editPick]').live('click',function (e) {					   
			e.preventDefault();
			$('#manualForm form#action').val('edit');
			openDialog(e, 'manualForm', this.id.split("|"));
		});	
		$('a[rel=autoPick]').live('click',function (e) {					   
			e.preventDefault();
			openDialog(e, 'autoForm', this.id.split("|"));
		});	
	    $('#btnCancel').live('click',function (e) {					   
			e.preventDefault();
			$.colorbox.close();
		});
		$('input[rel=auto_option]').live('click',function (e) {					   
			var display = 'none';
			if ($("input[@name=auto_option]:checked").val() == 'x_picks') {
				display = 'block';
			}	
			$('#pick_input').css('display',display);
		});
		
		$('#btnReset').css('display','none');
		$('#autorefresh').change(function() {
			if ($('#autorefresh').is(':checked')) {
				$('#lblEnable').empty();
				$('#lblEnable').html(labelDisableHTML);
				$('#countdown').empty();
				$('#countdown').html(counterActiveHTML);
				$('#btnReset').css('display','block');
				$('#countdown').startCountDown();
			} else {
				$('#lblEnable').empty();
				$('#lblEnable').html(labelEnableHTML);
				$('#countdown').stopCountDown();
				$('#countdown').empty();
				$('#btnReset').css('display','none');
			}
		});
		$('#btnReset').click(function() {
			refreshTimer();
		});
		$('#autoTime').change(function() {
			refreshTimer();
		});
		var autoTime = <?php print(((isset($thisItem['autoTime']) && !empty($thisItem['autoTime'])) ? $thisItem['autoTime'] : '""')); ?>;
		if (autoTime != null && autoTime != '') {
			$('#autoTime').val(parseInt(autoTime));
			$('#autorefresh').attr('checked', true);
		}
		refreshTimer();
		jQuery('.numbersOnly').keyup(function () { 
		    this.value = this.value.replace(/[^0-9\.]/g,'');
		});
	});
	function refreshTimer() {
		setTimer();
		$('#autorefresh').change();
	}
	function openDialog(e,id, params) {
		$('#'+id + ' input#league_id').val(params[0]);
		$('#'+id + ' input#pick_id').val(params[2]);
		$('#'+id + ' input#team_id').val(params[2]);
		$.colorbox({html:$('div#'+id).html()});
	}
	function setTimer() {
		theMinutes = 0;
		theSeconds = parseInt($('#autoTime').val());
		if (theSeconds > 60) {
			theMinutes = parseInt(theSeconds / 60);
			theSeconds = theSeconds - (theMinutes * 60);
		}
		$('#countdown').stopCountDown();
		$('#countdown').setCountDown({
			onComplete: function() { document.location.href = '<?php echo($config['fantasy_web_root']); ?>draft/info/id/<?php print($thisItem['draft_id']); ?>/autoTime/'+parseInt($('#autoTime').val());  },
			targetOffset: {
				'day': 		0,
				'month': 	0,
				'year': 	0,
				'hour': 	0,
				'min': 		parseInt(theMinutes),
				'sec': 		parseInt(theSeconds)
			}
		});
	}
    </script>
    <div id="manualForm" class="dialog">
		<form method='post' action="<?php echo($config['fantasy_web_root']); ?>draft/processDraft" name='manpick' id="manpick">
        <input type='hidden' id="action" name='action' value='manualpick'></input>
        <input type='hidden' id="team_id" name='team_id' value=''></input>
        <input type='hidden' id="pick_id" name='pick_id' value=''></input>
        <input type='hidden' id="league_id" name='league_id' value=''></input>
        <div class='textbox'>
         <table cellpadding=2 cellspacing=0 cellborder=0>
          <tr class='title'><td colspan=3>Draft Pick</td></tr>
          <tr>
           <td><label for='selection'>Player ID:</label></td>
           <td>
           <?php  
           if (isset($playerList) && sizeof($playerList) > 0) { ?>
           <select name="pick">
           <?php 
           		foreach ($playerList as $playerInfo) { ?>
					<option value="<?php print($playerInfo['id']); ?>"><?php print(get_pos($playerInfo['pos'])." - ".$playerInfo['last_name'].", ".$playerInfo['first_name']); ?></option>
				<?php 
           		} // END foreach
			?>
			</select>
			<?php 
           } else {
           		print ("Sorry, Draftable Player List not available.");
           }// END if
           ?>
           </td>
           <td><input type='submit' class="button" value='Draft Player'></input></td>
           <td><input type='button' id="btnCancel" class="button" value='Cancel'></input>
          </tr>
         </table>
        </div>
        </form>
	</div>
	
	<div id="autoForm" class="dialog">
		<form method='post' action="<?php echo($config['fantasy_web_root']); ?>draft/processDraft" name='autopick' id="autopick">
        <input type='hidden' id="action" name='action' value='auto'></input>
        <input type='hidden' id="team_id" name='team_id' value=''></input>
        <input type='hidden' id="pick_id" name='pick_id' value=''></input>
        <input type='hidden' id="league_id" name='league_id' value=''></input>
        <div class='textbox'>
         <table cellpadding=2 cellspacing=0 cellborder=0>
          <tr class='title'><td colspan=3>Options</td></tr>
          <tr>
           <td>&nbsp;</td>
           <td>
           <i>NOTE: This action will override any user auto draft setting in favor of making the auto picks</i><br />
           <input type="radio" rel="auto_option" name="auto_option" value="current" selected="selected" /> Current Pick Only <br />
           <input type="radio" rel="auto_option" name="auto_option" value="x_picks" /> X Number of Picks <br />
           <div id="pick_input"><label for='selection'>Enter Count:</label> <input type='text' id="pick_count" name='pick_count' value='' class="numbersOnly" maxlength="2"></input></div>
           <input type="radio" rel="auto_option" name="auto_option" value="round" /> Complete Round <br />
           <input type="radio" rel="auto_option" name="auto_option" value="all" /> Complete Entire Draft <br />
           </td>
          </tr>
          <tr>
           <td><input type='submit' class="button" value='Auto Draft'></input></td>
           <td><input type='button' id="btnCancel" class="button" value='Cancel'></input>
           </td>
          </tr>
         </table>
        </div>
        </form>
	</div>
	
	<div id="column-single">
		<?php 
		// EDIT 1.0.2
		// ADMIN MESSAGING FOR DRAFT CONTROLS
		$message = "";
		$messageType = "info";
		if ($accessLevel == ACCESS_ADMINISTRATE || $thisItem['isCommish']) {
			if ($thisItem['draftStatus'] < 2  || time() < strtotime($thisItem['draftDate'])) {
				$message = "<b>NOTE</b>: Your draft has not started yet. More controls will be available once the draft date and time are reached.";
			} else if ($thisItem['draftStatus'] == 4) {
				$message = "Your draft is complete! Return to the ".anchor('/league/admin/'.$thisItem['league_id'],'legaue admin screen')." to finalize your draft and set your league rosters in place!.";
				$messageType = "notice";
			}
		}
		if (!empty($message)) {
			echo '<div class="'.$messageType .'">'.$message.'</div>';
		}
		?>
        </div>
        <br clear="all" />
        <div id="center-column">
       	<div class="top-bar"><h1>Draft Results</h1></div>
        </div>
        <?php
		if ($thisItem['draftStatus'] < 4) { ?>
        <div id="right-column">
        <div class="inPageWidget">
            <div class="title">Auto refresh Page</div>
            <input type="checkbox" id="autorefresh" name="autorefresh" value="1" />	<b id="lblEnable">Enable</b><br />
            Refresh every <input id="autoTime" name="autoTime" class="numbersOnly" type="text" size="5" maxlength="4" value="30" /> seconds.<br />
            <div id="countdown"></div>
            <input type="button" id="btnReset" name="btnReset" value="Restart" class="button" />
        </div>
        </div>
		<?php } ?>
        
        <div id="column-center">
       	<div id="content">
		<?php $cols = 6; 
		$width='';
		if (($accessLevel == ACCESS_ADMINISTRATE || $thisItem['isCommish']) && $thisItem['draftStatus'] < 4) {
			$width=' style="width:800px;"';
		} ?>
		<div class='tablebox'<?php echo($width); ?>>
        <table cellspacing="0" cellpadding="3"<?php echo($width); ?>>
        <tr class='title'><td colspan="8">Draft Results</td></tr>
        <tr class='headline'>
            <td class='hsc2'>Rnd</td>
            <td class='hsc2'>Pick</td>
            <td class='hsc2'>Ovr</td>
            <td class='hsc2_l'>Team</td>
            <td class='hsc2'>Pos</td>
            <td class='hsc2_l'>Player</td>
            <?php
            if ($thisItem['draftStatus'] < 4 && ($accessLevel == ACCESS_ADMINISTRATE || $thisItem['isCommish'])) { ?>
            <td class='hsc2'>Action</td><td class='hsc2' nowrap="nowrap">Picked At</td>
            <?php
            $cols=8;
            } ?>
        </tr>
        <?php 
		
		
		if (isset($thisItem['draftResults']) && sizeof($thisItem['draftResults']) > 0) {
			$first = '';
			$pidList = "";
			$prevRnd=0;
			$tzone=date("T");
			$totCnt=1;
			$thisItem['teamList'] = $thisItem['teamList'];
			foreach ($thisItem['draftResults'] as $row) {
				$tid=$row['team_id'];
				$round=$row['round'];
				$pid=$row['player_id'];
				$pick=$row['pick_overall'];
				$dueDt=$row['due_date'];
				$dueTm=$row['due_time'];
				$dueText=$dueDt." ".$dueTm;
				
				if (($pid==-999)&&($thisItem['isCommish']!=1)) {continue;}

				if ($round!=$prevRnd) { ?>
                <tr class='title'><td colspan="<?php echo($cols); ?>">Round <?php echo($round); ?></td></tr>
                <?php $pcnt=0;
				} 
				$cls="s".($pcnt%2+1);
				?>
 				<tr class="<?php echo($cls); ?>">
					<td><?php echo($round); ?></td>
                    <td><?php echo($row['pick_round']); ?></td>
					<?php if ($pid == -999) { ?>
                    <td>&nbsp;</td>
                    <?php } else { ?>
                    <td><a name="<?php echo($totCnt); ?>>"><?php echo($totCnt); ?></a></td>
                    <?php } ?>
					<td class="<?php echo($cls); ?>_l"><?php echo($thisItem['teamList'][$tid]['teamname']." ".$thisItem['teamList'][$tid]['teamnick']); ?></a></td>
					<?php
                    if ($pid=="") {
                        if ($thisItem['timerEnable']==1) {
                            echo "<td colspan=2>Pick is due no later than $dueText $tzone</td>";
                        } else {
                            echo "<td colspan=2>&nbsp;</td>";
                        }
                    } elseif ($pid ==-999) {
						echo "<td align='center' colspan='2'>----- Skipped -----</td>";
					} else { ?>
                    	
						<td><?php echo(get_pos($thisItem['playersInfo'][$pid]['position'])); ?></td>
						<td class="<?php echo($cls); ?>_l"><?php echo anchor('/players/info/league_id/'.$thisItem['league_id'].'/player_id/'.$pid, $thisItem['playersInfo'][$pid]['first_name']." ".$thisItem['playersInfo'][$pid]['last_name']); ?></a></td>
					<?php }
					if ($accessLevel == ACCESS_ADMINISTRATE || $thisItem['isCommish']) { 
					 if ($thisItem['draftStatus'] > 0 && $thisItem['draftStatus'] < 4 && time() > strtotime($thisItem['draftDate'])) {
            		if ($pid=="") {
							if ($first=="") { ?>
						<td><?php echo anchor('#','Auto Pick',array('rel'=>'autoPick','id'=>$thisItem['league_id'].'|'.$pick.'|'.$tid)); ?>
						/<?php echo anchor('#','Manual Pick',array('rel'=>'makePick','id'=>$thisItem['league_id'].'|'.$pick.'|'.$tid)); ?></td>
							<?php $first=1;
							} else { ?>
                        <td><?php echo anchor('/draft/processDraft/league_id/'.$thisItem['league_id'].'/action/skip/pick_id/'.$pick.'/team_id/'.$tid,'Skip Pick'); ?>
                        <?php } ?>
						<td>&nbsp;</td>
                    <?php }  else {
						if ($pid!=-999) { ?>
                        <td>
                        <?php echo anchor('/draft/processDraft/league_id/'.$thisItem['league_id'].'/action/clear/pick_id/'.$pick,'Clear'); ?>/
                        <?php echo anchor('#','Edit',array('rel'=>'editPick','id'=>$thisItem['league_id'].'|'.$pick.'|'.$tid)); ?>/
                        <?php echo anchor('/draft/processDraft/league_id/'.$thisItem['league_id'].'/action/rollback/pick_id/'.$pick,'Rollback'); ?></td>
                        <td><?php echo $dueText; ?></td>
						<?php } else { ?>
						<td><?php echo anchor('/draft/processDraft/league_id/'.$thisItem['league_id'].'/action/clear/pick_id/'.$pick,'Restore'); ?></td>
						<td>&nbsp;</td>
						<?php  
						}
					}      
				} else {
					echo("<td></td><td></td>");
				}
					}
					
				?>
				</tr>
<?php
			$prevRnd=$round;
			$pcnt++;
			if ($pid!=-999) {$totCnt++;}
			}
		}
		?>

            	</table>
            </div>
        </div>
	</div>
