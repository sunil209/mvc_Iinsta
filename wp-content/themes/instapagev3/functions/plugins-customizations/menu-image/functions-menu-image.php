<?php
namespace Instapage;

add_action('wp_print_styles', 'Instapage\dequeueMenuImageStyle', 100);

/**
 * We do not need this style, it is blocking and completely not used by our beautiful site
 */
function dequeueMenuImageStyle() : void
{
    wp_dequeue_style('menu-image');
}
