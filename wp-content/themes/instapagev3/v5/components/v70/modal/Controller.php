<?php
namespace Instapage\Components\v70\Modal;

use \Instapage\Classes\RootComponent;

/**
 * Class used to encapsulate logic for modal component
 */
class Controller extends RootComponent
{
    protected $componentNamespace = __NAMESPACE__;

    /**
     * @param $params An array of parameters passed to component template.
     */
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
}
