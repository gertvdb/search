# Kos Search #

Provide a general wrapper class to execute searches.

# Usage #

Using the class.
 
```

use Drupal\searches\Search;
use Drupal\searches\SearchIndex;
use Drupal\searches\SearchTerm;
use Drupal\searches\FilterCollection;
use Drupal\searches\SorterCollection;

use Drupal\searches\Filters\DataSourceFilter;
use Drupal\searches\Filters\BundleFilter;
use Drupal\searches\Filters\StatusFilter;
use Drupal\searches\Sorters\PublicationDateSorter;

// Prepare Index.
$index = new SearchIndex('kos');

// Prepare filters.
$filters[] = new DataSourceFilter(['node']);
$filters[] = new BundleFilter(['activity']);
$filters[] = new StatusFilter(TRUE);

$filter_collection = new FilterCollection($filters);

// Prepare sorters.
$sorters[] = new PublicationDateSorter();
$sorter_collection = new SorterCollection($sorters);

// Prepare search term.
$parse_mode = \Drupal::service('plugin.manager.search_api.parse_mode')->createInstance('terms');
$fields = ['title', 'description'];
$term = new SearchTerm('Test', $parse_mode, $fields);

// Prepare search. (Search will not be executed untill method search is called upon object.)
$search = new Search($index, $term, $filter_collection, $sorter_collection);

// Prepare pagination data.
$current_page = 0;
$item_per_page = 5;

// Fire search.
// When no current page or items per page are passed the full result list will be returned.
$results = $search->search($current_page, $item_per_page);

// Get full result count.
$count = $search->searchCount();

// Get facets info.
$info = [
  'type' => [
    'field' => 'type',
    'limit' => 0,
    'min_count' => 0,
    'missing' => FALSE,
  ],
]
$facets = $search->searchFacets($info);

```

