<?php
/**
 * Simple footer default template
 *
 * It is so simple that it was decided to not paremtrize $year as it is no practical use cases
 * to parametrize year, it should be consistent in whole page
 */
?>
<section class="v7 v7-simple-footer">
    <div class="v7-content text-center">
        <?= '&copy; ' . date('Y') . ' ' . __('Postclick. All rights reserved.') ?>
    </div>
</section>

