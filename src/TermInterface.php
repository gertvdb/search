<?php

namespace Drupal\searches;

/**
 * Search.
 *
 * @package Drupal\searches
 */
interface TermInterface {

  /**
   * {@inheritdoc}
   */
  public function getTerm();

  /**
   * {@inheritdoc}
   */
  public function getParseMode();

  /**
   * {@inheritdoc}
   */
  public function getFullTextFields();

}
