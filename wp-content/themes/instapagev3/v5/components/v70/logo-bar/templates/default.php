<?php
use Instapage\Helpers\HtmlHelper;
?>
<div class="container <?= esc_attr($sectionClass ?? '') ?>">
    <a class="v7-logo-bar-wrapper v7-mt-30" href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
</div>
