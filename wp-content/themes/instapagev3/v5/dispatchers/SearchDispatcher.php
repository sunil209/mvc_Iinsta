<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\Data;
use Instapage\Classes\View;
use Instapage\Classes\Factory;

class SearchDispatcher
{
    public function __construct()
    {
        $queryPostType = get_query_var('post_type');
        $searchType = Data::_get('search_type');
        $querySearch = get_search_query();

        $this->renderV7Search($queryPostType, $querySearch, $searchType);
    }

    /**
     * @param string|array  $queryPostType Which post types we should look into?
     * @param string        $querySearch   What phrase user typed in to search form?
     * @param null|string   $searchType    Type of search if defined (for example `resoruces`
     */
    public function renderV7Search($queryPostType, string $querySearch, ?string $searchType) : void
    {
        $contextID = null;
        if ($searchType === 'resources') {
            $contextID = get_page_by_path('resources');
        } else {
            $page = get_query_var('post_type', getV5Page());
            $model = Factory::getModel($page);

            if (method_exists($model, 'getContextID')) {
                $contextID = $model->getContextID();
            }
        }

        View::render(
            'single-column',
            'search-post',
            [
                'postType' => $queryPostType,
                'querySearch' => $querySearch,
                'searchType' => $searchType,
                'contextID' => $contextID
            ]
        );
    }
}
