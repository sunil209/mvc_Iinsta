<?php

use Instapage\Classes\Component;

/**
 * Template file. Template params are stored in $params array
 * @example Basic usage
 * Component::render('v51/document-end');
 * @endexample
 */
?>

<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
<?php
Component::render('v51/render-delayed');
wp_footer();
?>
</body>
</html>
