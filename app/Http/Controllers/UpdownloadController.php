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
            'document' => 'required',
            'keterangan' => 'required',
            'type' => 'required',
        ]);

        $upload = $request->file('document');
        $path = $upload->store('public/storage');
        $nama_file = $upload->getClientOriginalName();

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
        $user = Document::findOrFail($id);
        // dd($user);
        $user->delete();
        // activity()->log('Menghapus OPD');
        return redirect('/upload-download');
    }

    public function download($id)
    {
        $dl = Document::where('type', '=', $id)->get();
        // $ds = $dl[0]->path;      // dd($dl);
        // dd($ds);
        // $ag = $dl->path;
        return Storage::download($dl[0]->path, $dl[0]->document);
    }
}
