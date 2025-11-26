# Cache Strategy


When QueryCacheStrategy::clear() is called without any parameters, all cache gets cleared.

But when QueryCacheStrategy::clear(cacheKey) is called with 'cacheKey', only that cache gets cleared.

QueryCacheStrategy::put() previously flushed the cache. But now it insert the new entity into the cache.

PostRepository handles the update() and get() based on the new strategy.

---------------------------------------

Test by running:

php artisan test --filter ExampleTest




