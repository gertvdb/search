<?php

namespace Drupal\searches\Search\Term;

use Drupal\searches\TermInterface;

/**
 * Search.
 *
 * @package Drupal\searches\Search\Term
 */
final class Term implements TermInterface {

  /**
   * The search term array.
   *
   * @var string|null
   */
  protected $term;

  /**
   * The parse mode for the term.
   *
   * @var \Drupal\search_api\ParseMode\ParseModeInterface|null
   */
  protected $parseMode;

  /**
   * The full text fields to search.
   *
   * @var array
   */
  protected $fields;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $term, $parse_mode = NULL, $fields = []) {
    $this->term = $term;
    $this->parseMode = $parse_mode;
    $this->fields = $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getTerm() {
    return $this->term;
  }

  /**
   * {@inheritdoc}
   */
  public function getParseMode() {
    return $this->parseMode;
  }

  /**
   * {@inheritdoc}
   */
  public function getFullTextFields() {
    return $this->fields;
  }

}
