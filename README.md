# Cache Strategy



New trait is added:

app/Models/Repositories/Trait/QueryCacheStrategy.php



---------------------------------------



1. Cache versioning is added.
2. Cache by index is added.
3. Entity identifiers are appended to the '$cacheKey' to be used when calling 'get()';



