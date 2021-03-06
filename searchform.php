<?php
/**
 * The template for displaying search forms in Schools
 *
 * @package schools
 */
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="sr-only"><?php _e('Search for:', 'schools'); ?></label>
  <div class="input-group">
    <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php _e('Search...', 'schools'); ?>">
    <span class="input-group-btn">
      <button type="submit" class="search-submit btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
    </span>
  </div>
</form>
