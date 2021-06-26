<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class DictionaryTermDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);

        if (is_single()) {
            $termId = get_the_ID();

            $params = [];
            $params['clickToTweet'] = $model->getClickToTweet($termId);
            $params['trendsChart'] = $model->getTrendsChart($termId);
            if (isAmp()) {
                View::render('amp', 'dictionary-single', $params);
            } else {
                $params['termDefinition'] = $model->getTermDefinition($termId);
                $params['videoUrl'] = $model->getVideoUrl($termId);
                $params['video'] = getVideoEmbed($termId);
                $params['googleTrends'] = $model->getGoogleTrends($termId);
                $params['dictionaryRelatedTerms'] = getDictionaryRelatedTerms($termId);
                $params['breadCrumbsItems'] = $model->getBreadCrumbsItems($termId);

                View::render('single-column', 'dictionary-single', $params);
            }
        } else {
            $contextID = $model->getContextID();

            $params['barItems'] = $model->getBarItems();
            $params['listingItems'] = $model->getListingItems();
            $params['contextID'] = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;

            View::render('single-column', 'dictionary-listing', $params);
        }
    }
}
