<?php

namespace Instapage\Classes;

/**
 * Class to send data to Hubspot on Button Click for the Plan. 
 */
class PlanButtonAjax
{
    /**
     * Activate Plan button ajax API endpoint, and do all initialization stuff
     *
     * @return void
     */
    public static function init()
    {
        add_action('wp_ajax_nopriv_plan_button', [PlanButtonAjax::class, 'sendButtonStatistic']);
        add_action('wp_ajax_plan_button', [PlanButtonAjax::class, 'sendButtonStatistic']);
    }

    /**
     * Controller of handle the Ajax Request api endpoint.
     *
     * Here is the beginning and here is the end of whole api call.
     *
     * @return void
     */
    public static function sendButtonStatistic()
    {
        print_R($_GET);
        wp_send_json_success($result);
    }
}
