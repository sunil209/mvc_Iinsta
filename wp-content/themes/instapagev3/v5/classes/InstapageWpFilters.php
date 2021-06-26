<?php
namespace Instapage\Classes;

/**
 * Class holding all custom Instapage filters names.
 *
 * Filters provide a way for functions to modify data of other functions.
 * Filters are meant to work in an isolated manner,
 * and should never have side effects such as affecting global variables and output.
 *
 * Reference: https://developer.wordpress.org/plugins/hooks/filters/
 *
 * @package Instapage\Classes
 */
class InstapageWpFilters
{
    const V7_LISTING_WP_QUERY = 'v7-listign-wp-query';
}
