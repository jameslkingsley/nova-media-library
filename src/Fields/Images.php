<?php

namespace Kingsley\NovaMediaLibrary\Fields;

use Laravel\Nova\Fields\MorphMany;

class Images extends MorphMany
{
    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        $payload = $arguments ?: [
            'Media', 'media',
            \Kingsley\NovaMediaLibrary\Resources\Media::class
        ];

        return new static(...$payload);
    }
}
