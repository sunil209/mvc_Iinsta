<?php

namespace Instapage\Models;

use Instapage\Helpers\StringHelper;

/**
 * Abstract class for component's model with iterator.
 *
 * What iterator means here? That you can call Component::render() methods
 * few times and it will automatically takes data from components acf repeater.
 *
 * Remember that for getting data in iterator component use get_sub_field function.
 *
 * ACF repeater needs to have name component_name_repeater. For example: left_right_repeater, benefit_repeater
 *
 */
abstract class IteratorComponent extends Component {
  /**
   * @var int[] Which iteration of component render it is?
   *            Iteration values is keept in associative array
   *            with key based on component's model class name
   */
  private static $iterations = [];

  /**
   * @var ?int[] Array holding count of component's repeater rows.
   *             Key is based on component's model class name
   */
  private static $componentsRepeatersRowsCount = [];

  /**
   *
   * @var ?String Name of main repeater for component. One row one set of data for one component's render
   */
  protected $repeaterName = null;

  /**
   * Repeater name for components are auto created, it is like component_name_repeater.
   * So for example for division header component which can be put on one page many times
   * with acf it will be: division_header_repeater
   *
   * @return string Component's main repeater name
   */
  protected function getComponentRepeaterName() : string {
    if ($this->repeaterName !== null) {
      return $this->repeaterName;
    }

    $className = (new \ReflectionClass($this))->getShortName();
    $classNameSlug = StringHelper::toSlug($className, '_');
    $this->repeaterName = str_replace('model', 'repeater', $classNameSlug);

    return $this->repeaterName;
  }

  /**
   * Get iteration count, how many times this component was rendered?
   *
   * @return int
   */
  protected function getIterationCount() : int {
    return self::$iterations[get_called_class()] ?? 0;
  }

  /**
   * Increase iteration counter, do it only once on one render
   *
   * @return void
   */
  protected function increaseIterationCount() : void {
    self::$iterations[get_called_class()] = $this->getIterationCount() + 1;
  }

  /**
   * How many sets of date we have for component? For example if we have 3 rows in
   * main component's repeater it means that we can render this component three times:
   * in first render it will use data from the first row, in second from the second row etc.
   *
   * @return integer How many rows are there in main component's repeater?
   */
  protected function getNumberOfComponentRepeaterRows() : int {
    if (isset(self::$componentsRepeatersRowsCount[get_called_class()])) {
      return self::$componentsRepeatersRowsCount[get_called_class()];
    }

    $componentRepeater = get_field($this->getComponentRepeaterName());
    self::$componentsRepeatersRowsCount[get_called_class()] = count(is_array($componentRepeater) ? $componentRepeater : []);

    return self::$componentsRepeatersRowsCount[get_called_class()];
  }

  /**
   * Iterator component's consume data, so it means that each set of data can be used once.
   *
   * @return bool Are there any data to render?
   */
  protected function isThereAnythingToFetch() : bool {
    // there is assumption that on one iteration one row is fetched
    return $this->getIterationCount() < $this->getNumberOfComponentRepeaterRows();
  }

  /**
   * Set ACF context for proper row, so get_sub_field() function can work and fetch data from proper place
   */
  protected function setACFContext() : void {
    reset_rows();
    $row = 0;

    if (have_rows($this->getComponentRepeaterName())) {
      while ($row <= $this->getIterationCount()) {
        $row++;
        the_row();
      }
    }
  }

  /**
   * Clear ACF context, it is very handy function when iteration ends - it rewinds internal acf iterator.
   */
  protected function clearACFContext() : void {
    // if this is last row it will rewind itereation to the first row
    have_rows($this->getComponentRepeaterName());
  }

  /**
   * Standard function for fetching component's params,
   * but this one fetch data from proper row of component's repeater
   *
   * @param array $params Parameters of components
   * @return array Paramaeters of component with data fetch from ACF
   */
  public function fetchComponentParams(array $params = []) : array {
    // if all rows were consumed, return $params not altered
    if (!$this->isThereAnythingToFetch()) {
      return $params;
    }

    $this->setACFContext();
    $paramsFetched = parent::fetchComponentParams($params);
    $this->clearACFContext();
    $this->increaseIterationCount();

    return $paramsFetched;
  }
}
