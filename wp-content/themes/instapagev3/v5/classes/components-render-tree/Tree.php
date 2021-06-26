<?php

namespace Instapage\Classes\ComponentsRenderTree;

use Instapage\Classes\Component;
use Instapage\Classes\ComponentsRenderTree\Node;

/**
 * This class holds component render tree. Which component was render inside of another, etc.
 */
class Tree {
  /**
   * @var Node Root main node
   */
  protected $root;

  /**
   * @var Node Component being rendered now
   */
  protected $active;

  public function __construct() {
    $this->root = new Node('root-node');
    $this->active = $this->root;
  }

  /**
   * Register component's render in components render tree. We assume that components
   * render is synchronous operation, so we now that every new componentRenderStart() method
   * call before componentRenderStop() tells us that this is child component
   *
   * @param string $componentName
   */
  public function componentRenderStart(string $componentName) : void {
    $orderNumber = count($this->active->getChildrenComponents());
    $newComponentNode = new Node($componentName, $this->active, $orderNumber);
    $this->active->addChildComponent($newComponentNode);
    $this->active = $newComponentNode;
  }

  /**
   * Rendering of component stopped, so we now that all child components was rendered.
   */
  public function componentRenderStop() {
    $this->active = $this->active->getParentComponent();
  }

  /**
   * Get root component.
   *
   * @return Node
   */
  public function getRoot() : Node {
    return $this->root;
  }


  /**
   * Get current component's node.
   *
   * @return Node
   */
  public function getCurrentComponent() : Node {
    return $this->active;
  }

  /**
   * Get currently rendered component's path.
   *
   * @return string Component's render path
   */
  public function getCurrentRenderPath() : string {
    return $this->readNodeRenderPath($this->active);
  }

  /**
   * Read unique render path of given component's node.
   *
   * @param Node $node
   * @return string Render path
   */
  public function readNodeRenderPath(?Node $node) : string {
    if ($node === null) {
      return '';
    }

    return
      $this->readNodeRenderPath($node->getParentComponent())
      . '##' . $node->getComponentName() . '~' . $node->getOrderNumber();
  }

  /**
   * Check if active component has cached parrent?
   * It is not necessary to cache sub component as parent component is cached.
   */
  public function checkIfComponentHasCachedParent() : bool {
    return $this->checkIfNodeHasCachedParent($this->active);
  }

  /**
   * Check if given component's node has cached parrent?
   * It is not necessary to cache sub component as parent component is cached
   */
  public function checkIfNodeHasCachedParent(?Node $node) : bool {
    if ($node === null || $node->getParentComponent() === null) {
      return false;
    }

    if ($node->getParentComponent()->isCached()) {
      return true;
    }

    return $this->checkIfNodeHasCachedParent($node->getParentComponent());
  }


  /**
   * Check if any of parents is on components cache blacklist
   *
   * @return bool
   */
  public function checkIfAnyOfParentsIsPermanentlyNotCached() :bool {

    return $this->checkIfNodeParentIsPermanentlyNotCached($this->active);
  }

  /**
   * Check if parent is on components cache blacklist
   *
   * @param \Instapage\Classes\ComponentsRenderTree\Node|null $node
   *
   * @return bool
   */
  public function checkIfNodeParentIsPermanentlyNotCached(?Node $node) : bool {
    if ($node === null || $node->getParentComponent() === null) {
      return false;
    }

    $parentName = $node->getParentComponent()->getComponentName();

    if (in_array($parentName, Component::$doNotCacheComponents)) {
      return true;
    }

    return $this->checkIfNodeParentIsPermanentlyNotCached($node->getParentComponent());
  }
}
