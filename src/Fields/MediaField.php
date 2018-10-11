<?php

namespace Kingsley\NovaMediaLibrary\Fields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Deletable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Contracts\Deletable as DeletableContract;

abstract class MediaField extends Field implements DeletableContract
{
    use Deletable;

    /**
     * The media collection.
     *
     * @var string
     */
    public $mediaCollection;

    /**
     * The media collection methods
     * to apply to this field.
     *
     * @var array
     */
    protected $mediaLibraryMethods = [];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Create a new field.
     *
     * @return void
     */
    public function __construct(string $name, string $collection = 'default')
    {
        parent::__construct($name);

        $this->mediaCollection = $collection;

        $this->delete(function () {
            //
        });
    }

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
            $requestAttribute => $this->validationRules
        ]);

        $query = $model->addMedia($request[$requestAttribute]);

        foreach ($this->mediaLibraryMethods as $method => $arguments) {
            $query->$method(...$arguments);
        }

        $query->toMediaCollection($this->mediaCollection);
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
        $customProperties = $this->mediaLibraryMethods['withCustomProperties'] ?? [];
        $media = $resource->getMedia($this->mediaCollection);

        if (!empty($customProperties)) {
            $customProperties = array_first($customProperties) ?: [];
            $media = $media->first(function ($item) use ($customProperties) {
                foreach ($customProperties as $property => $value) {
                    $valid = ($valid ?? true) && $item->getCustomProperty($property) == $value;
                }
                return $valid ?? false;
            });
        } else {
            $media = $media->first();
        }

        return $media ?? null;
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
