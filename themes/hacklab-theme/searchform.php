<form action="/" method="get">
	<input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php _e('buscar', 'hacklbr');?>"/>
	<input class="button" type="submit" id="searchsubmit" value="New search" />
</form>
