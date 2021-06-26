<?php
namespace Instapage\Classes;

use Instapage\Helpers\StringHelper;
use Instapage\Models\Component as ComponentModel;
use Instapage\Classes\{
    ComponentCache,
    ComponentsRenderTree\Tree
};

class NoTemplateException extends \Exception
{

    public function __construct($variation, $component)
    {
        $this->message = 'No ' . $variation . ' variation found in ' . $component . ' component';
    }
}

class Component
{
    const DUMB = '_dumb';

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @var string[] Component's name to exclude from caching
     */
    public static $doNotCacheComponents = [
        'v51/document-start',
        'v51/document-end',
        'v51/image',
        'amp/document-start'
    ];

    /**
     * @var int Internal counter of component::render method, how many time it was used among request?
     */
    protected static $renderCounter = 0;

    /**
     * @var Tree
     */
    public static $componentsRenderTree = null;

    /**
     * Try to get object for component's model
     *
     * @param  string $componentName Component name.
     * @param  string $version       Version of component to get model.
     *
     * @return ComponentModel|null Component's model object if there is one or null if model is not defined
     */
    public static function getComponentModel(string $componentName, string $version): ?ComponentModel
    {
        $componentNameStudly = StringHelper::toStudlyCaps($componentName);
        $className           = '\\Instapage\\Components\\' . $version . '\\' . $componentNameStudly . '\\' . $componentNameStudly . 'Model';
        $componentModel      = null;

        if (class_exists($className)) {
            $componentModel = new $className();
        }

        return $componentModel;
    }

    /**
     * Get components render tree, one for all components render
     *
     * @return Tree
     */
    public static function getComponentsRenderTree(): Tree
    {
        if (self::$componentsRenderTree === null) {
            self::$componentsRenderTree = new Tree();
        }

        return self::$componentsRenderTree;
    }

    /**
     * This is the method which is responsible for starting all actions related to component's model.
     *
     * Function starts looking for component's model and if found one execut function for fetching component's params from model
     * if not it returnes not altered component's params array.
     *
     * @param  string $componentName Component name.
     * @param  string $version       Version of component to get model.
     * @param  array  $params        An array of parameters passed to component template.
     *
     * @return  array  $params An array of parameters passed to component template plus data auto fetched from model.
     */
    public static function getParamsFromComponentModel(string $componentName, string $version, array $params): array
    {
        $componentModel = static::getComponentModel($componentName, $version);
        if ($componentModel instanceof ComponentModel) {
            $params = $componentModel->fetchComponentParams($params);
        }

        return $params;
    }

    /**
     * Get component main path
     *
     * @param  string $componentName Component name.
     * @param  string $version       Version of component to get model.
     *
     * @return string Main path of rendered component
     */
    public static function componentMainPath(string $componentName, string $version): string
    {
        return get_template_directory() . '/v5/components/' . $version . '/' . $componentName;
    }

    /**
     * Renders given component, from cache of fresh render
     *
     * @param  string $component Component name.
     * @param  string $variation Component variation. Default value is 'default'.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return void
     */
    public static function render($component = '', $variation = 'default', $params = [])
    {
        if (is_array($variation)) {
            $params    = $variation;
            $variation = 'default';
        }
        self::getComponentsRenderTree()->componentRenderStart($component);
        self::$renderCounter++;
        if (self::shouldComponentBeCached($component, $params)) {
            self::fromCacheRender($component, $variation, $params);
            self::getComponentsRenderTree()->componentRenderStop();

            return;
        }
        self::freshRender($component, $variation, $params);
        self::getComponentsRenderTree()->componentRenderStop();
    }

    /**
     * What is dumb render? It means that even if model exists it is never actually run,
     * it renders component based only on data passed in params.
     * Name inspired by React dumb components.
     *
     * Usage is simple, instead of calling Component::render() we just use Component::dumbRender()
     *
     * @param  string $component Component name.
     * @param  string $variation Component variation. Default value is 'default'.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return void
     */
    public static function dumbRender($component = '', $variation = 'default', $params = []): void
    {
        if (is_array($variation)) {
            $params    = $variation;
            $variation = 'default';
        }

        $params[self::DUMB] = true;
        self::render($component, $variation, $params);
    }

    /**
     * Render component using data from cache
     *
     * @param  string $component Component name.
     * @param  string $variation Component variation. Default value is 'default'.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return void
     */
    protected static function fromCacheRender($component = '', $variation = 'default', $params = [])
    {
        $cache    = \Instapage\Classes\Factory::getCache();
        $cacheKey = self::componentCacheKey($component);
        $render   = $cache::get($cacheKey);

        // this component is not cached, render it, cache it
        if ($render === false) {
            // update components render tree with info that this component will be cached
            self::getComponentsRenderTree()->getCurrentComponent()->setCachedState();

            ob_start();
            self::freshRender($component, $variation, $params);
            $render = ob_get_contents();
            ob_end_clean();
            // save to cache
            $cache::set($cacheKey, $render);
        }

        // component is cached, so echo it
        echo $render;
    }

    /**
     * Check if this component shoudl be cached?
     *
     * @param  string $component Component name.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return bool
     */
    protected static function shouldComponentBeCached($component = '', $params = []): bool
    {
        /* check if is preview
        checking if caching of components is enabled OR
        if any of parents is permamently disabled from caching then don't cache this component */
        if (get_field('is_caching_enabled', 'option') === false
            || (isset($params['doNotCache']) && $params['doNotCache'] === true)
            || is_preview()
            || self::getComponentsRenderTree()->checkIfAnyOfParentsIsPermanentlyNotCached()
        ) {
            return false;
        }

        if (self::$renderCounter <= 1) {
            self::mergeNotCacheComponentsList();
        }

        return
            // check if component is not on the list of not cached components?
            ! in_array($component, self::$doNotCacheComponents)
            // and check that component's parent is not cached.
            && ! self::getComponentsRenderTree()->checkIfComponentHasCachedParent();
    }

    /**
     * Create cache key for component
     *
     * @param string $componentName
     *
     * @return string Cache key for component
     */
    protected static function componentCacheKey($componentName = '')
    {
        // add request uri to the key
        $cacheKey = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $cacheKey .= '_' . self::getComponentsRenderTree()->getCurrentRenderPath();

        $cacheKey = md5($cacheKey);

        // on singular object request add also ID, to refresh cache only when this object is updated
        if (is_singular()) {
            $queriedObject = get_queried_object();
            $id            = $queriedObject->ID ?? null;
            $cacheKey      .= ComponentCache::keySuffixAssociatedWithObjectID($id);
            // otherwise always refresh cache
        } else {
            $cacheKey .= ComponentCache::keySuffixForDeletingOnAnySave();
        }

        return $cacheKey;
    }

    /**
     * Renders given component.
     *
     * @param  string $component Component name.
     * @param  string $variation Component variation. Default value is 'default'.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return void
     */
    protected static function freshRender($component = '', $variation = 'default', $params = [])
    {
        if (!$component) {
            return;
        }

        if (strpos($component, '/') !== false) {
            list($version, $componentName) = explode('/', $component, 2);
        } else {
            $version       = 'v70';
            $componentName = $component;
        }

        $templatePath = self::componentMainPath($componentName, $version) . '/templates/' . $variation . '.php';

        // if model exists for component try to auto fetch nonset parameters from model
        // BUT if this is dumb render do not fetchy anything from model
        if (!self::isDumb($params ?? [])) {
            $params = self::getParamsFromComponentModel($componentName, $version, $params);
        }

        if (!file_exists($templatePath)) {
            throw new NoTemplateException($variation, $component);
        }

        extract($params, EXTR_OVERWRITE);
        include($templatePath);
    }

    /**
     * Check if component is dumb, condition is based on components paramaters.
     * Setting $params[Component::DUMB] to true is changing component to dumb one,
     * easy reuse of templates.
     *
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @return bool
     */
    public function isDumb(array $params = []): bool
    {
        return isset($params[self::DUMB])
               && $params[self::DUMB] === true;
    }

    /**
     * Fetches HTML of given component. Calls self::render() internally
     *
     * @param  string $component Component name.
     * @param  string $variation Component variation. Default value is 'default'.
     * @param  array  $params    An array of parameters passed to component template.
     *
     * @uses   self::render()
     * @return string HTML of given component
     */
    public static function fetch()
    {
        ob_start();
        call_user_func_array(['self', 'render'], func_get_args());
        $component = ob_get_contents();
        ob_end_clean();

        return $component;
    }

    /**
     * Add to declared not cache component, array of components names dynamicly added
     */
    public static function mergeNotCacheComponentsList()
    {
        $items = [];

        if (have_rows('not_cached_components', 'option')) {
            while (have_rows('not_cached_components', 'option')) {
                the_row();
                $items[] = get_sub_field('component_name');
            }
        }

        self::$doNotCacheComponents = array_merge(self::$doNotCacheComponents, $items);
    }

}
