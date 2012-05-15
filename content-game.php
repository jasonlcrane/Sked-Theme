<?php 
					$isHome = 'away-game';
					$opponent = get_post_meta($post->ID, 'opponent', TRUE);
					$gametime = get_post_meta($post->ID, 'gametime', TRUE);
					$gamedate = get_post_meta($post->ID, 'gamedate', TRUE);
					$gamelocation = get_post_meta($post->ID, 'gamelocation', TRUE);
					if ($gamelocation == 'Fort Worth, TX') {
						$isHome = 'home-game';
					}
					$gametv = get_post_meta($post->ID, 'gametv', TRUE);
					$gameresult = get_post_meta($post->ID, 'gameresult', TRUE);
					$result = 'upcoming'; 
					if ($gameresult != '') {	
						$win = explode('-',$gameresult);
						if ($win[0] > $win[1]) {
							$result = 'win';
							$resultText = 'w';
						}
						else {
							$result = 'loss';
							$resultText = 'l';
						}
					}
					echo '<li class="' . $result . ' ' . $isHome .'"><h2>';
					
					echo $opponent;
					if ($gameresult != '') {
						echo '<span class="score">' . $gameresult . '</span>';
						echo '<span class="result">' . $resultText . '</span>';
					}
					echo '</h2>';
					if ($gameresult == '') { 
						echo '<p><span class="gametime">' . $gametime . '</span><span class="gamedate">' . $gamedate . '</span>';
						echo '<span class="gamelocation">' . $gamelocation . '</span>';
						if ($gametv != '') {
							echo '<span class="gametv">TV: ' . $gametv . '</span></p>';
						}
					}
					echo '</li>';
			?>