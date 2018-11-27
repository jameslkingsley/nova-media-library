<?php

namespace Kingsley\NovaMediaLibrary\Fields;

use Laravel\Nova\Http\Requests\NovaRequest;

class Image extends MediaField
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-media-library-image-field';

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $validationRules = ['image'];

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param  mixed  $resource
     * @param  string  $attribute
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        $media = parent::resolveAttribute($resource, $attribute);

        $conversion = $this->meta()['usingConversion'] ?? [];

        if ($media) {
            if ($media->hasGeneratedConversion($conversion)) {
                $media->preview_url = url($media->getUrl($conversion));
            } else {
                $media->preview_url = url($media->getUrl());
            }
        }

        return $media;
    }

    /**
     * Set the width of the image.
     * Accepts CSS values (100px, 10rem, 10% etc.)
     *
     * @return $this
     */
    public function width($value)
    {
        return $this->withMeta(['width' => $value]);
    }

    /**
     * Set the height of the image.
     * Accepts CSS values (100px, 10rem, 10% etc.)
     *
     * @return $this
     */
    public function height($value)
    {
        return $this->withMeta(['height' => $value]);
    }

    /**
     * Set the width and height of the image.
     * Accepts CSS values (100px, 10rem, 10% etc.)
     *
     * @return $this
     */
    public function size(string $value)
    {
        return $this->withMeta([
            'width' => $value,
            'height' => $value,
        ]);
    }

    /**
     * Defines what conversion to use when displaying the image.
     *
     * @return $this
     */
    public function usingConversion(string $name)
    {
        return $this->withMeta(['usingConversion' => $name]);
    }

    /**
     * Dynamically set a media-library setting on the field.
     *
     * @return $this
     */
    public function __call($method, $arguments)
    {
        $this->mediaLibraryMethods[$method] = $arguments;

        return $this;
    }

    /**
     * Get additional meta information to merge with the element payload.
     *
     * @return array
     */
    public function meta()
    {
        return array_merge([
            'deletable' => isset($this->deleteCallback) && $this->deletable
        ], $this->meta);
    }
}
