<?php

namespace Drupal\searches\Search;

use Drupal\searches\SearchInterface;
use Drupal\searches\IndexInterface;
use Drupal\searches\TermInterface;
use Drupal\searches\FilterCollectionInterface;
use Drupal\searches\SorterCollectionInterface;

/**
 * Search.
 *
 * @package Drupal\searches\Search
 */
final class Search implements SearchInterface {

  /**
   * The search index.
   *
   * @var \Drupal\search_api\IndexInterface
   */
  protected $index;

  /**
   * The search query.
   *
   * @var \Drupal\search_api\Query\QueryInterface
   */
  protected $query;

  /**
   * The original search query.
   *
   * @var \Drupal\search_api\Query\QueryInterface
   */
  protected $originalQuery;

  /**
   * A boolean indicating if the query is prepared.
   *
   * This way we can prevent the filters/sorters to be
   * applied more than once.
   *
   * @var bool
   */
  protected $prepared;

  /**
   * The search server.
   *
   * @var \Drupal\search_api\ServerInterface
   */
  protected $server;

  /**
   * The search term object.
   *
   * @var \Drupal\searches\TermInterface|null
   */
  protected $term;

  /**
   * A filter collection.
   *
   * @var \Drupal\searches\FilterCollectionInterface|null
   */
  protected $filterCollection;

  /**
   * A sorter collection.
   *
   * @var \Drupal\searches\SorterCollectionInterface|null
   */
  protected $sorterCollection;

  /**
   * {@inheritdoc}
   */
  public function __construct(IndexInterface $index, TermInterface $term = NULL, FilterCollectionInterface $filter_collection, SorterCollectionInterface $sorter_collection) {
    $this->index = $index->getIndex();
    $this->query = $this->index->query();
    $this->originalQuery = clone $this->query;
    $this->server = $this->index->getServerInstance();
    $this->term = $term;
    $this->filterCollection = $filter_collection;
    $this->sorterCollection = $sorter_collection;
    $this->prepared = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function search($page = NULL, $item_per_page = NULL) {

    // When search is triggered we prepare the query.
    $this->prepareQuery();

    // When page and items per page are passed we add a range to the query.
    if (($page !== NULL) && $item_per_page) {
      $start = $page * $item_per_page;
      $this->query->range($start, $item_per_page);
    }

    // getResultItems could trigger an exception,
    // we want our search to show no results on an error,
    // so we wrap it in a try catch.
    try {
      $results = $this->query->execute()->getResultItems();
    }
    catch (\Exception $e) {
      $results = FALSE;
    }

    // Restore the query to before it was manipulated by this function.
    $this->restoreQuery();
    return !empty($results) ? $results : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function searchCount() {
    $this->prepareQuery();

    // Make sure we get all items.
    $this->query->range(0, 0);

    // getResultCount could trigger an exception,
    // we want our search to show no results on an error,
    // so we wrap it in a try catch.
    try {
      $count = $this->query->execute()->getResultCount();
    }
    catch (\Exception $e) {
      $count = 0;
    }

    // Restore the query to before it was manipulated by this function.
    $this->restoreQuery();
    return $count;
  }

  /**
   * {@inheritdoc}
   */
  public function searchFacets($facets) {
    $this->prepareQuery();

    if (!$this->server->supportsFeature('search_api_facets')) {
      return FALSE;
    }

    $this->query->setOption('search_api_facets', $facets);
    $this->query->range(0, 0);

    // getResultCount could trigger an exception,
    // we want our search to show no results on an error,
    // so we wrap it in a try catch.
    try {
      $facets = $this->query->execute()->getExtraData('search_api_facets', array_keys($facets));
    }
    catch (\Exception $e) {
      $facets = FALSE;
    }

    // Restore the query to before it was manipulated by this function.
    $this->restoreQuery();
    return $facets;
  }

  /**
   * {@inheritdoc}
   */
  private function restoreQuery() {
    $this->query = clone $this->originalQuery;
  }

  /**
   * {@inheritdoc}
   */
  private function prepareQuery() {
    if (!$this->prepared) {
      $this->applyTermsToQuery();
      $this->applyFiltersToQuery();
      $this->applySortersToQuery();
      $this->originalQuery = clone $this->query;
      $this->prepared = TRUE;
    }
  }

  /**
   * {@inheritdoc}
   */
  private function applyTermsToQuery() {

    // When term is set add it to the query.
    if ($this->term) {

      // When no parse mode is set fallback to default.
      if ($this->term->getParseMode()) {
        // Set the parse mode for the search.
        $this->query->setParseMode($this->term->getParseMode());
      }

      // When no field are set search all full text fields.
      if ($this->term->getFullTextFields()) {
        // Set the full text fields to search.
        $this->query->setFulltextFields($this->term->getFullTextFields());
      }

      if ($this->term->getTerm()) {
        // Set fulltext search keywords.
        $this->query->keys($this->term->getTerm());
      }

    }
  }

  /**
   * {@inheritdoc}
   */
  private function applyFiltersToQuery() {

    // Get all fields on index.
    $index_fields = $this->index->getFields(TRUE);

    // Loop over the filters and apply them.
    if ($this->filterCollection) {

      /** @var \Drupal\searches\FilterInterface $filter */
      foreach ($this->filterCollection->getIterator() as $filter) {

        // Make sure we only apply filters that implement
        // the SearchFilterInterface.
        $should_apply_filter = TRUE;
        $filter_fields = $filter->getDependentFields();

        // Make sure we only apply the filter when all fields
        // defined by filter class are present in SOLR.
        foreach ($filter_fields as $filter_field_key => $filter_field) {
          if (!in_array($filter_field, array_keys($index_fields))) {
            $should_apply_filter = FALSE;
            break;
          }
        }

        // When check is passed call the apply method on filter class
        // to append the filter to the query.
        if ($should_apply_filter) {
          $this->query = $filter->apply($this->query, $this->index);
        }
      }

    }
  }

  /**
   * {@inheritdoc}
   */
  private function applySortersToQuery() {

    // Get all fields on index.
    $index_fields = $this->index->getFields(TRUE);

    // Loop over the sorters and apply them.
    if ($this->sorterCollection) {

      /** @var \Drupal\searches\SorterInterface $sorter */
      foreach ($this->sorterCollection->getIterator() as $sorter) {

        // Make sure we only apply sorters that implement
        // the SearchSorterInterface.
        $should_apply_sorter = TRUE;
        $sorter_fields = $sorter->getDependentFields();

        // Make sure we only apply the sorter when all fields
        // defined by filter class are present in SOLR.
        foreach ($sorter_fields as $sorter_field_key => $sorter_field) {
          if (!in_array($sorter_field, array_keys($index_fields))) {
            $should_apply_sorter = FALSE;
            break;
          }
        }

        // When check is passed call the apply method on sorter class
        // to append the sorter to the query.
        if ($should_apply_sorter) {
          $this->query = $sorter->apply($this->query);
        }
      }
    }
  }

}
