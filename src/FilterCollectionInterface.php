<?php

namespace Drupal\searches;

/**
 * FilterCollectionInterface.
 */
interface FilterCollectionInterface extends \IteratorAggregate {

  /**
   * Count the collection.
   *
   * @return int
   *   The count of the filters in the collection.
   */
  public function count();

  /**
   * Add a filter to the collection.
   *
   * @param \Drupal\searches\FilterInterface $filter
   *   A filter object.
   */
  public function add(FilterInterface $filter);

  /**
   * Override a filter in collection.
   *
   * @param int $key
   *   A numeric key.
   * @param \Drupal\searches\FilterInterface $filter
   *   A filter object.
   */
  public function override($key, FilterInterface $filter);

  /**
   * Get the filter collection.
   *
   * @return \Drupal\searches\FilterInterface[]
   *   The collection array.
   */
  public function getCollection();

}
