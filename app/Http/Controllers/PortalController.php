<?php

namespace App\Http\Controllers;

use App\Services\CkanApi\Facades\CkanApi;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $groups = CkanApi::group()->all(['limit' => 60]);
        $groups = $groups['result'] ?? [];
        return view('portal.landingpage.beranda', compact('groups'));
    }

    public function tentang()
    {
        return view('portal.landingpage.tentang');
    }

    public function data(Request $request)
    {
        $searchQuery = [
            'q' => $request->get('q'),
            'sort' => $request->get('sort', 'score desc, metadata_modified desc'),
        ];

        $searchQuery['fq'] = [];
        if ($request->filled('group')) {
            $searchQuery['fq'][] = 'groups:' . $request->get('group');
        }
        if ($request->filled('org')) {
            $searchQuery['fq'][] = 'organization:'. $request->get('org');
        }
        $searchQuery['fq'] = implode(' AND ', $searchQuery['fq']);

        $data = CkanApi::dataset()->all($searchQuery);
        $orgs = CkanApi::organization()->all();
        $groups = CkanApi::group()->all();

        $data = $data['success'] ? $data['result']['results'] : [];
        $orgs = $orgs['success'] ? $orgs['result'] : [];
        $groups = $groups['success'] ? $groups['result'] : [];

        return view('portal.landingpage.data', compact('data', 'orgs', 'groups'));
    }

    public function berita()
    {
        return view('portal.landingpage.berita');
    }
    public function ckan()
    {
        return view('portal.landingpage.ckan');
    }
    // public function ckan()
    // {
    //     return redirect('login');
    // }
}
