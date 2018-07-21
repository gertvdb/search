<?php

namespace Drupal\searches;

use Drupal\search_api\Query\QueryInterface;

/**
 * Interface SearchSortInterface.
 *
 * @package Drupal\searches
 */
interface SorterInterface {

  /**
   * Apply sort condition.
   *
   * @param \Drupal\search_api\Query\QueryInterface $query
   *   A query interface object to apply a condition to.
   *
   * @return \Drupal\search_api\Query\QueryInterface
   *   A query interface object.
   */
  public function apply(QueryInterface $query);

  /**
   * Get a list of fields the sorter depends on.
   *
   * @return array
   *   An array of field names.
   */
  public function getDependentFields();

}
