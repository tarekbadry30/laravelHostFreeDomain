<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function deleteDirectory( $path ) {
        $file = new Filesystem;
        $file->cleanDirectory( $path );
        Storage::deleteDirectory( $path );
        if(is_dir($path)) {
            rmdir( $path );
        }
    }
}
