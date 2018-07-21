<?php

namespace Drupal\searches\Search\Collections;

use Drupal\searches\SorterCollectionInterface;
use Drupal\searches\SorterInterface;

/**
 * SorterCollection.
 *
 * @package Drupal\searches\Search\Collections
 */
final class SorterCollection implements SorterCollectionInterface {

  /**
   * An array of sorters to apply.
   *
   * @var \Drupal\searches\SorterInterface[]
   */
  protected $sorters;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $sorters = []) {
    $this->sorters = $sorters;
  }

  /**
   * {@inheritdoc}
   */
  public function count(){}

  /**
   * {@inheritdoc}
   */
  public function add(SorterInterface $filter){}

  /**
   * {@inheritdoc}
   */
  public function override($key, SorterInterface $filter){}

  /**
   * {@inheritdoc}
   */
  public function getCollection(){}

}
