<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class UpdownloadController extends Controller
{
    public function index()
    {
        $document = Document::get();
        return view('pages.contents.administrator.download', compact('document'));
    }

    public function proses_upload(Request $request)
    {
        $this->validate($request, [
            'document' => 'required|mimes:xlsx,xls',
            'keterangan' => 'required',
            'type' => 'required',
        ]);

        $upload = $request->file('document');
        $path = $upload->store('public/storage');
        $nama_file = date('Ymd') . '-' .$upload->getClientOriginalName();

        Document::create([
            'document' => $nama_file,
            'path' => $path,
            'keterangan' => $request->keterangan,
            'type' => $request->type,
        ]);

        return redirect('/upload-download');
    }

    public function destroy($id)
    {
        Document::findOrFail($id)->delete();
        return redirect('/upload-download');
    }

    public function download($id)
    {
        $doc = Document::where('type', '=', $id)->firstOrFail();
        return Storage::download($doc->path, $doc->document);
    }
}
