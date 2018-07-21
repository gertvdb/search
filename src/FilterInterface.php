<?php

namespace Drupal\searches;

use Drupal\search_api\Query\QueryInterface;

/**
 * Interface FilterInterface.
 *
 * @package Drupal\searches
 */
interface FilterInterface {

  /**
   * Apply filter condition.
   *
   * @param \Drupal\search_api\Query\QueryInterface $query
   *   A query interface object to apply a condition to.
   *
   * @return \Drupal\search_api\Query\QueryInterface
   *   A query interface object.
   */
  public function apply(QueryInterface $query);

  /**
   * Get a list of fields the filter depends on.
   *
   * @return array
   *   An array of field names.
   */
  public function getDependentFields();

}
