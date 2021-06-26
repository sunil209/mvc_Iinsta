<?php

/**
 * Generating key for rapid cache is complex process,
 * we need to generate key which really reflects variation of HTML,
 * for example ?mkt_tok=uniquq_id doesn't change HTML when `s` GET parameters does change,
 * so we will incorporate only `s` parameter to generate cache key
 */
class RapidCacheKeyGenerator
{
    /**
     * This GET parameters will be taken into cache key
     */
    private const ALLOWED_GET_PARAMETERS = [
        'utm_medium',
        'utm_source',
        'utm_term',
        'utm_content',
        'utm_campaign',
        's', // search query
        'post_type', // search post type
        'search_type', // search type
        'p', // preview for editors
        'preview', // preview for editors
    ];

    /**
     * Get cache key based on passed url, we leave only whitelisted GET parameters
     *
     * @param string $url Url of page that RapidCache wants manage cache
     *
     * @return string Cache key which is used by rapid cache for given page url
     */
    public function getKeyBasedOnUrl(string $url) : string
    {
        $urlProcessed = $this->processUrlForKeyGeneration($url);
        /*
         * TODO: Check if we really need to truncate md5? We risk that we will have collision
         * This line is moved from rapid cache, for safety we will not improve this in this task
         */
        return substr('qc_'. md5($urlProcessed), 0, 32);
    }

    /**
     * Prepare URL (path + query) as a seed for generation cache key, we want keep only
     * this GET parameters which results in changing HTML content
     *
     * @param string $url
     *
     * @return string
     */
    private function processUrlForKeyGeneration(string $url) : string
    {
        $urlQueryVariables = $this->getQueryVariablesFromUrl($url);
        $urlQueryVariablesFiltered = array_intersect_key(
            $urlQueryVariables,
            array_flip(self::ALLOWED_GET_PARAMETERS)
        );

        $processedUrl = parse_url($url, PHP_URL_PATH);
        $urlQuery = http_build_query($urlQueryVariablesFiltered);

        if (strlen($urlQuery) > 0) {
            $processedUrl .= '?' . $urlQuery;
        }

        return $processedUrl;
    }

    /**
     * Get query variables from url as an array
     *
     * @param string $url
     *
     * @return array
     */
    private function getQueryVariablesFromUrl(string $url) : array
    {
        $queryVariables = [];
        $query = parse_url($url, PHP_URL_QUERY);

        if ($query !== null) {
            parse_str($query,$queryVariables);
        }

        return $queryVariables;
    }
}
