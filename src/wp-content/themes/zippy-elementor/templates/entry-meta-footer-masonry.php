<?php
$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
$write_comments = "";

if ( comments_open() ) {
    if ( $num_comments == 0 ) {
        $comments = esc_html__('No Comments', 'uplands');
    } elseif ( $num_comments > 1 ) {
        $comments = $num_comments . esc_html__(' Comments', 'uplands');
    } else {
        $comments = esc_html__('1 Comment', 'uplands');
    }
    $write_comments = '| <a href="' . esc_url(get_comments_link()) .'">'. $comments.'</a>';
}
?>
<div class="date-meta">
    <i class="xs-icon fa fa-calendar-o"></i>
    <!--div class="post-meta"-->
        <span class="show-author"><?php the_author_posts_link(); ?></span> |
        <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
        <span class="show-comments"><?php echo wp_kses_post( $write_comments ); ?></span>
    <!--/div-->
    <span class="is-sticky"><?php echo esc_html__('Featured Post', 'uplands'); ?></span>
</div>