<?php

namespace Kingsley\NovaMediaLibrary\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * Deletes the given media resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Media $media)
    {
        $media->delete();
    }
}
