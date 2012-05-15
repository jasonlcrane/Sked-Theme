<?php 
// include get_site() . '/wp-config.php';
if (isset($_REQUEST['season'])) {
				$season = $_REQUEST['season'];
			}
			else {
				$season = '2011';
			}
			query_posts( array ( 'post_type' => 'game', 'category_name' => $season, 'order' => 'ASC', 'posts_per_page' => 20 ) );
				// query_posts( 'post_type=game&order=asc&category=2012' );
				// loop through game posts
				while ( have_posts() ) : the_post();
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
						echo '<p><i class="icon-calendar"></i><span class="gametime">' . $gametime . '</span><span class="gamedate">' . $gamedate . '</span>';
						echo '<span class="gamelocation"><i class="icon-map-marker"></i>' . $gamelocation . '</span>';
						if ($gametv != '') {
							echo '<span class="gametv"><i class="icon-play-circle"></i>TV: ' . $gametv . '</span></p>';
						}
					}
					echo '</li>';
				endwhile;
				// Reset Query
				wp_reset_query();
			?>