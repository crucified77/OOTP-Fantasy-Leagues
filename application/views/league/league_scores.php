	<script type="text/javascript">
    $(document).ready(function(){		   
		
	});
    </script>
    <div id="subPage">
        <div class="top-bar"> <h1><?php echo $subTitle; ?></h1></div>
        <div id="content">
                <!-- BEGIN RIGHT COLUMN -->
            <div id="metaColumn"> 
				<?php if (isset($rosters) && sizeof($rosters) > 0) { ?>
				<div class='textbox'>
			    <table cellpadding="0" cellspacing="0" border="0" style="width:255px;">
			    <tr class='title'>
			    	<td style='padding:6px' colspan="2">Roster Restrictions</td>
			    </tr>
			    <tr>
			    	<td>
					<table cellpadding="2" cellspacing="0" border="0" style="width:100%;">
				    <tr class='headline'>
				    	<td width="70%">Pos</td>
						<td width="35%">Lineup Min</td>
						<td width="35%">Lineup Max</td>
					</tr>
					<?php foreach($rosters as $pos => $data) { ?>
					<tr class='slg_1'>
				    	<td class="hsc2_l"><?php echo(get_pos($pos)); ?></td>
						<td class="hsc2_r"><?php echo($data['lineup_max']); ?></td>
						<td class="hsc2_r"><?php echo($data['total_max']); ?></td>
					</tr>
						<?php } ?>
					
					</table>
					</td>
				</tr>
				</table>
				</div>
				<div style="margin:6px 0 6px 0;min-height:12px;"><br clear="all" class="clear" /></div>
              	<?php } ?>
				
				<div class='textbox'>
			    <table cellpadding="0" cellspacing="0" border="0" style="width:255px;">
			    <tr class='title'>
			    	<td style='padding:6px' colspan="2">Point Scoring Values</td>
			    </tr>
			    <tr>
			    	<td>
					<table cellpadding="2" cellspacing="0" border="0" style="width:100%;">
				    <tr class='headline'>
				    	<td width="70%">Batting Category</td>
						<td width="35%">Points</td>
					</tr>
					<?php if (isset($scoring_batting) && sizeof($scoring_batting) > 0) {
							foreach($scoring_batting as $cat => $val) { ?>
					<tr class='slg_1'>
				    	<td class="hsc2_l"><?php echo(get_ll_cat($cat)); ?></td>
						<td class="hsc2_r"><?php echo($val); ?></td>
					</tr>
						<?php }
					}
					?>
					<tr class='headline'>	
						<td>Pitching Category</td>
						<td>Points</td>
				    </tr>
					<?php if (isset($scoring_pitching) && sizeof($scoring_pitching) > 0) {
							foreach($scoring_pitching as $cat => $val) { ?>
					<tr class='slg_1'>
						
				    	<td class="hsc2_l"><?php echo(get_ll_cat($cat)); ?></td>
						<td class="hsc2_r"><?php echo($val); ?></td>
					</tr>
						<?php }
					}
					?>
					</table>
					</td>
				</tr>
				</table>
				</div>
				<div style="margin:6px 0 6px 0;min-height:12px;"><br clear="all" class="clear" /></div>
               </div>
                   <!-- BEGIN MAIN COLUMN -->
               <div id="detailColumn">
			
		        <br class="clear" />
				<p>
				<b>Roster Notes:</b>
				</p>
				
				<p>
				<b>Position Eligibility</b><br />
				Each team has a Utility position, which is a "wildcard" spot where any player, except pitchers, can be placed at any time.
				</p>
				<p>
				The Utility position is filled in the same manner for both Rotisserie and Head-to-Head leagues, although there are differences between Live Drafts and Automated Drafts. In Live Drafts, the first player drafted at a position other than pitcher that is already "filled" (in terms of the lineup maximums specified above) is placed at the one utility spot allowed for in leagues. In AL-only or mixed leagues, you can draft an available Designated Hitter for an open Utility spot as well. In head-to-head leagues, you can still draft a Designated Hitter if your Utility position is filled and you have a reserve spot available.
				</p>
				<p>
				In all Automated Drafts, once all batter positions are filled, the next best available batter is placed at the Utility position.
				</p>
				<p>
				Once the draft is complete, you may select any player from the pool of Free Agents to use at the Utility position.
				</p>
				<p>
				During the season, all MLB players will remain eligible at their initial (pre-season) designated primary position, and will also be eligible at any position at which they played at least 20 games in 2009 or at least 5 games in 2010. Also, be aware that a player's primary position may change at any time. 
				</p>
				
				<p>
				<b>Scoring Notes:</b>
				</p>
				<ul>		
					<li>A team's score is tabulated daily.
					<li>Pitchers' hitting stats will not generate any hitting points, and batter's pitching stats will not generate pitching points.
					<li>A player will accumulate hitting stats whether or not he plays at the position designated by the Commissioner. (e.g., Nick Swisher is listed at OF on a Fantasy team's roster and if he plays 1B in a particular game. His hitting stats in that game will still count towards his Fantasy team's total points.)
					<li>Only official regular season MLB games will be used to determine Fantasy points. Minor league or exhibition stats generated by your players will not be used.
					<li>In the event that there are any regular season tie-breaker playoff games, the statistics accumulated in such games will NOT be counted towards your overall Rotisserie score. /p>
		        </ul>
		        <p>&nbsp;</p>
			</div>
		</div>
    </div>
    <p /><br />