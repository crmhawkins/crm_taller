<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Remove the specified media from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Encuentra el media por su ID
        $media = Media::findOrFail($id);

        // Elimina el media
        $media->delete();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Imagen eliminada exitosamente.');
    }
}