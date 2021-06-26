<?php

namespace Instapage\Classes\ComponentsRenderTree;

/**
 * Components node, representing component render
 */
class Node {
  /**
   * @var Node[] Array of child components, rendered inside this component.
   */
  protected $childrenComponents = [];

  /**
   * Order number of component in proper tree level [this one where component was rendered]
   */
  protected $orderNumber;

  /**
   * @var string
   */
  protected $componentName;

  /**
   * @var bool
   */
  protected $cached = false;

  /**
   * @var Node
   */
  protected $parentComponent;

  public function __construct(string $componentName, ?Node $parentComponent = null, int $orderNumber = 0) {
    $this->componentName = $componentName;
    $this->parentComponent = $parentComponent;
    $this->orderNumber = $orderNumber;
  }

  /**
   * Add component rendered inside in given component
   */
  public function addChildComponent(?Node $component) : void {
    $this->childrenComponents[] = $component;
  }

  /**
   * Get parent component
   */
  public function getParentComponent() : ?Node {
    return $this->parentComponent;
  }

  public function getComponentName() : string {
    return $this->componentName;
  }

  public function getChildrenComponents() : array {
    return $this->childrenComponents;
  }

  public function getOrderNumber() : int {
    return $this->orderNumber;
  }

  /**
   * Checks if component is cached by component's cache mechanism
   */
  public function isCached() : bool {
    return $this->cached;
  }

  /**
   * Set that component is cached
   */
  public function setCachedState() : void {
    $this->cached = true;
  }
}
