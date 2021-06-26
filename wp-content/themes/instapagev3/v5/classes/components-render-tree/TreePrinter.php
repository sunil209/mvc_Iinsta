<?php

namespace Instapage\Classes\ComponentsRenderTree;

use Instapage\Classes\ComponentsRenderTree\{
  Tree,
  Node
};

/**
 * Class responsible for printing Components Render Tree
 */
class TreePrinter {
  /**
   * @var Tree
   */
  protected $treeToPrint;

  /**
   * @var Int
   */
  protected $currentTreeLevel = 0;

  public function __construct(Tree $treeToPrint) {
    $this->treeToPrint = $treeToPrint;
  }

  /**
   * Print tree
   */
  public function printTree() : void {
    $rootNode = $this->treeToPrint->getRoot();
    $this->printNode($rootNode);
  }

  /**
   * Print nodes recursively
   *
   * @param Node $node
   * @param int $currentTreeLevel
   */
  protected function printNode(Node $node, int $currentTreeLevel = 0) : void {
    echo str_repeat("\t", $currentTreeLevel) . $node->getComponentName() .
         ' -> [path: ' . $this->treeToPrint->readNodeRenderPath($node). ']';

    echo "\n";

    /**
     * @var Node[]
     */
    $childrenComponents = $node->getChildrenComponents();

    foreach ($childrenComponents as $childrenComponent) {
      $this->printNode($childrenComponent, $currentTreeLevel + 1);
    }
  }
}
