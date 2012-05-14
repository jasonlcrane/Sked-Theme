<?php
/*
Template Name: Schedule
*/

get_header(); ?>
<?php query_posts( 'post_type=game' );
	// counts wins and losses for totals
	$wins = 0;
	$losses = 0;
	while ( have_posts() ) : the_post();
		$gameresult = get_post_meta($post->ID, 'gameresult', TRUE);
		if ($gameresult != '') {	
			$win = explode('-',$gameresult);
			if ($win[0] > $win[1]) {
				$wins++;
			}
			else {
				$losses++;
			}
		}
	endwhile;
	// Reset Query
	wp_reset_query();
?>

<div id="primary">
	<div id="content" role="main">
		<h1>TCU <span>2011</span> 
		<!-- img src="http://www.rifframbahzoo.com/wp-content/uploads/2011/09/helmet.png" width="30" / --></h1>
		<!-- div id="video">
			<iframe width="555" height="305" src="http://www.youtube.com/embed/wdG9jIgFiG8?wmode=opaque&autoplay=1&autohide=1" frameborder="0" allowfullscreen allowtransparency></iframe>
		</div -->
		<div id="filter">
			<a href="#" id="filter-all" class="active">All</a>
			<a href="#" id="filter-upcoming">Upcoming</a>
			<a href="#" id="filter-home">Home</a>
		</div>
		<div id="record">
			<?php echo $wins; ?> - <?php echo $losses; ?>
		</div>
		<ul id="games">
			<?php query_posts( 'post_type=game&order=asc' );
        		// loop through game posts
				while ( have_posts() ) : the_post();
                    get_template_part( 'content', 'game' );
                endwhile;
    			// Reset Query
				wp_reset_query();
            ?>
		</ul>

		<p class="note">All times Central</p>
		<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
			<!-- a class="addthis_button_facebook_like" fb:like:layout="button_count"></a -->
			<a class="addthis_button_facebook"></a>
			<a class="addthis_button_twitter"></a>
			<a class="addthis_button_compact"></a>
		</div>
		<script type="text/javascript">
			var addthis_config = {"data_track_clickback":true};
			var addthis_share = {templates: { twitter: 'Who does TCU play next? Ask @rifframbahzoo. {{url}}'}};
		</script>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=rifframbahzoo"></script>
	</div><!-- #content -->
</div><!-- #primary -->

<!-- ?php get_sidebar(); ? -->
<?php get_footer(); ?>