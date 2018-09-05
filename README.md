# Laravel Nova Media Library
This package is designed to be used with the [awesome media library package from Spatie](https://github.com/spatie/laravel-medialibrary). With this package you can add an image field for uploading single files to a resource, and add an images field to resources to display all of their associated media.

```php
use Kingsley\NovaMediaLibrary\Fields\Image;

Image::make('Avatar')
    ->usingConversion('thumb')
    ->preservingOriginal()
    ->toMediaCollection('avatar')
```

In this example we're defining a field called `Avatar` that uses the `thumb` conversion as the image to be displayed (on detail and index). The other methods called are **dynamically** applied to the upload request - **this lets you call any media-library method on the field.**.

If you want it to remove the old image before uploading the new one, be sure to make your model's media collection a [single file collection](https://docs.spatie.be/laravel-medialibrary/v7/working-with-media-collections/defining-media-collections#single-file-collections).

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
