# Cache Strategy



New trait is added:

app/Models/Repositories/Trait/QueryCacheStrategy.php



---------------------------------------



1. Cache versioning is added.
2. Cache by index is added.
3. Entity identifiers are appended to the '$cacheKey' to be used when calling 'get()';


---------------------------------------

Test by running:

./vendor/bin/phpunit --filter 'ExampleTest::test_cache_get_one_by_id'

./vendor/bin/phpunit --filter 'ExampleTest::test_cache_get_all_by_ids'

./vendor/bin/phpunit --filter 'ExampleTest::test_cache_get_one_by_category_id'

./vendor/bin/phpunit --filter 'ExampleTest::test_cache_get_all_by_category_ids'




