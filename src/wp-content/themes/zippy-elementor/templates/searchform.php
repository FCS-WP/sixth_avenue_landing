<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="input-group">
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field form-control" placeholder="<?php esc_attr_e('Search', 'uplands'); ?> <?php bloginfo('name'); ?>">
    <label class="hide"><?php esc_html_e('Search for:', 'uplands'); ?></label>
    <span class="input-group-btn">
      <button type="submit" class="search-submit btn btn-default"><?php esc_html_e('Search', 'uplands'); ?></button>
    </span>
  </div>
</form>