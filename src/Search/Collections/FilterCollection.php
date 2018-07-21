<?php

namespace Drupal\searches\Search\Collections;

use Drupal\searches\FilterCollectionInterface;
use Drupal\searches\FilterInterface;

/**
 * Search.
 *
 * @package Drupal\searches\Search\Collections
 */
final class FilterCollection implements FilterCollectionInterface {

  /**
   * An array of filters to apply.
   *
   * @var \Drupal\searches\FilterInterface[]
   */
  protected $filters;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $filters = []) {
    $this->filters = $filters;
  }

  /**
   * {@inheritdoc}
   */
  public function count(){}

  /**
   * {@inheritdoc}
   */
  public function add(FilterInterface $filter){}

  /**
   * {@inheritdoc}
   */
  public function override($key, FilterInterface $filter){}

  /**
   * {@inheritdoc}
   */
  public function getCollection(){}

}
