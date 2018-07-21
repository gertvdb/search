<?php

namespace Drupal\searches\Index;

use Drupal\search_api\Entity\Index as SearchApiIndex;
use Drupal\searches\IndexInterface;

/**
 * Index.
 *
 * @package Drupal\searches\Index
 */
class Index implements IndexInterface {

  /**
   * The search index.
   *
   * @var \Drupal\search_api\IndexInterface
   */
  protected $index;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $index) {
    $this->index = SearchApiIndex::load($index);
  }

  /**
   * Get the search index.
   *
   * @return \Drupal\search_api\IndexInterface|bool
   *   A IndexInterface object or NULL when index is not found.
   */
  public function getIndex() {
    return $this->index;
  }

  /**
   * Check index for field.
   *
   * @param string $field
   *   The field to check.
   *
   * @return bool
   *   A boolean indicating if field exists on index.
   */
  public function hasField($field) {
    if (!$this->getIndex()) {
      return FALSE;
    }
    return in_array($field, $this->getIndexFields($this->index));
  }

  /**
   * Get all fields for the given index.
   *
   * @return array[string]
   *   An array of fields present on the index.
   */
  public function getIndexFields() {
    return array_keys($this->index->getFields(TRUE)) ?: [];
  }

}
