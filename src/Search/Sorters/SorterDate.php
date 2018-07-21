<?php

namespace Drupal\searches\Search\Sorters;

use Drupal\search_api\Query\QueryInterface;
use Drupal\searches\SorterInterface;

/**
 * PublicationDateSorter.
 *
 * @package Drupal\searches\Search\Sorters
 */
class SorterDate implements SorterInterface {

  /**
   * The order to sort.
   *
   * @var string
   */
  protected $order;

  /**
   * Constructor.
   *
   * @param string $order
   *   The order to sort.
   */
  public function __construct(string $order = 'desc') {
    $this->order = NULL;
    if (in_array($order, ['asc', 'desc'])) {
      $this->order = $order;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function apply(QueryInterface $query) {

    // When no order is set just return the query object.
    if (!$this->order) {
      return $query;
    }

    $query->sort('published_at', $this->order);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function getDependentFields() {
    return ['published_at'];
  }

}
