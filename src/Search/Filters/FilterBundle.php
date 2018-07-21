<?php

namespace Drupal\searches\Search\Filters;

use Drupal\search_api\Query\QueryInterface;
use Drupal\searches\FilterInterface;

/**
 * BundleFilter.
 *
 * @package Drupal\searches\Search\Filters
 */
class FilterBundle implements FilterInterface {

  /**
   * A list of bundles to filter.
   *
   * @var array[]
   */
  protected $bundles;

  /**
   * Constructor.
   *
   * @param array[] $bundles
   *   An array of bundles (ex. article, event, ...).
   */
  public function __construct(array $bundles = []) {
    $this->bundles = $bundles;
  }

  /**
   * {@inheritdoc}
   */
  public function apply(QueryInterface $query) {

    // When no data sources are set just return the query object.
    if (empty($this->bundles)) {
      return $query;
    }

    $query->addCondition('type', $this->bundles, 'IN');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function getDependentFields() {
    return ['type'];
  }

}
