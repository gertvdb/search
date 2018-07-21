<?php

namespace Drupal\searches;

/**
 * SorterCollectionInterface.
 */
interface SorterCollectionInterface extends \IteratorAggregate {

  /**
   * Count the collection.
   *
   * @return int
   *   The count of the sorters in the collection.
   */
  public function count();

  /**
   * Add a sorter to the collection.
   *
   * @param \Drupal\searches\SorterInterface $sorter
   *   A sorter object.
   */
  public function add(SorterInterface $sorter);

  /**
   * Override a sorter in collection.
   *
   * @param int $key
   *   A numeric key.
   * @param \Drupal\searches\SorterInterface $sorter
   *   A sorter object.
   */
  public function override($key, SorterInterface $sorter);

  /**
   * Get the sorter collection.
   *
   * @return \Drupal\searches\SorterInterface[]
   *   The collection array.
   */
  public function getCollection();

}
