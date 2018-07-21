<?php

namespace Drupal\searches\Search\Filters;

use Drupal\search_api\Query\QueryInterface;
use Drupal\searches\FilterInterface;

/**
 * SearchFilterStatus.
 *
 * @package Drupal\searches\Search\Filters
 */
class FilterStatus implements FilterInterface {

  /**
   * The status to filter.
   *
   * @var bool
   */
  protected $status;

  /**
   * Constructor.
   *
   * @param bool $status
   *   The status to filter.
   */
  public function __construct(bool $status = TRUE) {
    $this->status = $status;
  }

  /**
   * {@inheritdoc}
   */
  public function apply(QueryInterface $query) {

    $query->addCondition('status', $this->status, '=');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function getDependentFields() {
    return ['status'];
  }

}
