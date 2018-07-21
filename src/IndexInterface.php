<?php

namespace Drupal\searches;

/**
 * Interface IndexInterface.
 *
 * @package Drupal\searches
 */
interface IndexInterface {

  /**
   * Get the search index.
   *
   * @return \Drupal\search_api\IndexInterface
   *   A IndexInterface object
   */
  public function getIndex();

  /**
   * Check index for field.
   *
   * @param string $field
   *   The field to check.
   *
   * @return \Drupal\search_api\IndexInterface
   *   An IndexInterface object
   */
  public function hasField($field);

  /**
   * Get all fields for the given index.
   *
   * @return array[string]
   *   An array of fields.
   */
  public function getIndexFields();

}
