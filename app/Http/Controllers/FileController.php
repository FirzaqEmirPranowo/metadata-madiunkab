<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function preview(Request $request)
    {
        abort_unless($request->filled('payload'), 400);

        try {
            $filepath = Crypt::decryptString($request->get('payload'));
        } catch (\Exception $exception) {
            return response('Bad Request', 400);
        }

        abort_unless(Storage::exists($filepath), 404, 'File tidak ditemukan!');

        return response()->file(Storage::path($filepath));
    }
}
