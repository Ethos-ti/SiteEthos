<form action="/" method="get">
	<input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php _e('search', 'hacklabr');?>"/>
	<input class="button" type="submit" id="searchsubmit" value="<?php _e('New search', 'hacklabr');?>" />
</form>
