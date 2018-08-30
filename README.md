# Media Library Field
This field is designed to be used with the [media library package from Spatie](https://github.com/spatie/laravel-medialibrary). It currently only supports single file uploading. Take a look at the example usage below:

```php
use Kingsley\MediaLibraryImage\MediaLibraryImage;

MediaLibraryImage::make('Avatar')
    ->usingConversion('thumb')
    ->preservingOriginal()
    ->toMediaCollection('avatar')
```

In this example we're defining a field called `Avatar` that uses the `thumb` conversion as the image to be displayed (on detail and index). The other methods called are **dynamically** applied to the upload request - **this lets you call any media-library method on the field.** When updating the field above it will store the image like this:

```php
// Must be uploading an image
$request->validate([
    $requestAttribute => 'image'
]);

// Kick off the media-library process
$query = $model->addMedia($request[$requestAttribute]);

// Call any of the media-library methods on the query
foreach ($request->all() as $key => $value) {
    if (starts_with($key, 'ml_')) {
        $method = substr($key, 3);
        $arguments = is_array($value) ? $value : [$value];
        $query->$method(...$arguments);
    }
}
```
