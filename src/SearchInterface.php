<?php

namespace Drupal\searches;

/**
 * Interface SearchInterface
 *
 * @package Drupal\searches
 */
interface SearchInterface {

  /**
   * {@inheritdoc}
   */
  public function search($page = NULL, $item_per_page = NULL);

  /**
   * {@inheritdoc}
   */
  public function searchCount();

  /**
   * {@inheritdoc}
   */
  public function searchFacets($facets);

}
