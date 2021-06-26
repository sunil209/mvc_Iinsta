<?php
/**
 * Template file for rel="prev" and rel="next" metatags based on custom field values.
 */
use Instapage\Classes\Component;

$relPrev = get_field('link_rel_prev');
$relNext = get_field('link_rel_next');

if ($relPrev) {
  Component::render('v51/rel-metatag', ['type' => 'prev', 'url' => $relPrev]);
}

if ($relNext) {
  Component::render('v51/rel-metatag', ['type' => 'next', 'url' => $relNext]);
}
