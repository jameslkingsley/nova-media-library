<?php

namespace Kingsley\NovaMediaLibrary\Fields;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Deletable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Contracts\Deletable as DeletableContract;

class Image extends Field implements DeletableContract
{
    use Deletable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-media-library-image-field';

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if (! $request[$requestAttribute]) {
            return;
        }

        $request->validate([
            $requestAttribute => 'image'
        ]);

        $query = $model->addMedia($request[$requestAttribute]);

        foreach ($request->all() as $key => $value) {
            if (starts_with($key, 'ml_')) {
                $method = substr($key, 3);
                $arguments = is_array($value) ? $value : [$value];
                $query->$method(...$arguments);
            }
        }

        if (!$request->has('ml_toMediaCollection')) {
            $query->toMediaCollection();
        }
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param  mixed  $resource
     * @param  string  $attribute
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        $collection = $this->meta()['ml_toMediaCollection'][0] ?? null;
        $conversion = $this->meta()['usingConversion'] ?? [];
        $media = $resource->getFirstMedia($collection);

        if (empty($media)) {
            return null;
        }

        if ($media->hasGeneratedConversion($conversion)) {
            $media = $media->getUrl($conversion);
        } else {
            $media = $media->getUrl();
        }

        return url($media);
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
        return $this->withMeta(['ml_' . $method => $arguments]);
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
