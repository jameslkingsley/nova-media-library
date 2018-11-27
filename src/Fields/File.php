<?php

namespace Kingsley\NovaMediaLibrary\Fields;

class File extends MediaField
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-media-library-file-field';

    protected $validationRules = ['file'];
}
