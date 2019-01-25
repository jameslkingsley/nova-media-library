# Laravel Nova Media Library

## Attention: Please consider using [this package](https://github.com/ebess/advanced-nova-media-library) instead, it has a lot more support for various medialibrary features, and will probably fit your needs better!

This package is designed to be used with the [awesome media library package from Spatie](https://github.com/spatie/laravel-medialibrary). With this package you can add an image field for uploading single files to a resource, a generic file field for other types, and add an images field to resources to display all of their associated media.

```php
use Kingsley\NovaMediaLibrary\Fields\Image;

Image::make('Avatar', 'avatar')
    ->usingConversion('thumb')
    ->preservingOriginal()
```

In this example we're defining a field called `Avatar` that uses the `avatar` collection. It's also calling `usingConversion` to set the `thumb` conversion as the image to be displayed (on detail and index). The other methods called are **dynamically** applied to the upload request - **this lets you call any media-library method on the field.**.

If you want it to remove the old image before uploading the new one, be sure to make your model's media collection a [single file collection](https://docs.spatie.be/laravel-medialibrary/v7/working-with-media-collections/defining-media-collections#single-file-collections).

When you want to upload a file that isn't an image, you can use the rudimentary `File` field included with this package. It follows the same format as registering an `Image` field.

```php
use Kingsley\NovaMediaLibrary\Fields\File;

File::make('Invoice', 'invoice')
```

That's all there is to it! The rest of the configuration should be done in the media collection itself, such as:

```php
public function registerMediaCollections()
{
    $this
        ->addMediaCollection('invoice')
        ->singleFile()
        ->acceptsFile(function (File $file) {
            return $file->mimeType === 'application/pdf';
        });
}
```

To show all media records for your resource simply add the `Images` field like so:

```php
use Kingsley\NovaMediaLibrary\Fields\Images;

public function fields(Request $request)
{
    return [
        ...
        Images::make(),
    ];
}
```

This will automatically use the `media` attribute on your model (which the `HasMediaTrait` adds).

**Note: You currently cannot create media directly from Nova.**

#### Registering the media resource

If you'd like to use the media resource included with this package, you need to register it manually in your `NovaServiceProvider` in the `boot` method.

```php
Nova::resources([
    \Kingsley\NovaMediaLibrary\Resources\Media::class
]);
```
