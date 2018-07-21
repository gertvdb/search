<?php

namespace Drupal\searches\Search\Filters;

use Drupal\search_api\Query\QueryInterface;
use Drupal\searches\FilterInterface;

/**
 * DataSourceFilter.
 *
 * @package Drupal\searches\Search\Filters
 */
class FilterDataSource implements FilterInterface {

  const PREFIX = 'entity:';

  /**
   * Entity types.
   *
   * @var array[]
   */
  protected $entityTypes;

  /**
   * Constructor.
   *
   * @param array[] $entity_types
   *   An array of entity types.
   */
  public function __construct(array $entity_types = []) {
    // Initialize list of entity types.
    $this->entityTypes = [];
    if (!empty($entity_types)) {

      // Add search prefix to the passed entity.
      foreach ($entity_types as $entity_type) {
        $this->entityTypes[] = self::PREFIX . $entity_type;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function apply(QueryInterface $query) {

    // When no entity types are set just return the query object.
    if (empty($this->entityTypes)) {
      return $query;
    }

    $query->addCondition('search_api_datasource', $this->entityTypes, 'IN');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function getDependentFields() {
    // Datasource will always be present.
    return [];
  }

}
