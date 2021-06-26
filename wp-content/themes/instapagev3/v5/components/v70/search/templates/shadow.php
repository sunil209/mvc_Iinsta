<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param bool   $searchBtn                Displays search button
 * @param string $placeholder              Search input placeholder
 *
 * @example Default
 *  Component::render(
 *    'header',
 *    [
 *      'headerSlot' => Component::fetch('search', 'shadow', ['placeholder' => 'Search...'])
 *    ]
 * );
 *
 * @endexample
 *
 * @example With button
 *  Component::render(
 *    'header',
 *    [
 *      'headerSlot' => Component::fetch('search', 'shadow', ['placeholder' => 'Search...', 'searchBtn' => true])
 *    ]
 * );
 *
 * @endexample
 *
 */

use \Instapage\Classes\Component;
?>
<div class="v7-search-shadow-wrapper js-search-container v7-mt-40 v7-mt-md-60">
    <div
    role="search"
    class="v7-search-shadow v7-mx-auto">
        <input
            class="v7-search-input v7-search-input-shadow js-search <?= $searchBtn ? 'has-btn' : '' ?>"
            placeholder="<?= esc_attr($placeholder ?? ' ') ?>"
            autocomplete="off"
            type="text"
            name="search">
        <span role="icon" class="material-icons v7-search-icon">search</span>
        <?php
        if ($searchBtn) :
            Component::render('button', [
                'text' => __('SEARCH NOW'),
                'url' => '#',
                'class' => 'v7-search-shadow-btn v7-btn-cta'
            ]);
        endif
        ?>
        <ul class="v7-autocomplete-suggestions js-suggestions is-hidden"></ul>
    </div>
</div>
