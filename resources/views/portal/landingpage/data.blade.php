@extends('portal.landingpage.layout')

@section('header')
    <div class="container">
        <div class="page-banner home-banner h-75 py-4">
            <div class="row align-items-center flex-wrap-reverse">
                <div class="col-md-12 py-0 my-0 px-5 wow fadeInLeft">
                    <h1 class="mb-4">Pencarian Dataset</h1>
                    <form>
                        <div class="d-flex mb-4">
                            <input class="form-control" placeholder="Cari data" name="q" value="{{old('q', request()->q)}}">
                            <select class="form-control form-select w-25" name="org">
                                <option value=""> - Organisasi / OPD - </option>
                                @foreach($orgs as $org)
                                    <option value="{{$org['name']}}" {{request()->get('org') == $org['name'] ? 'selected' : ''}}>{{$org['title']}}</option>
                                @endforeach
                            </select>
                            <select class="form-control form-select w-25" name="group">
                                <option value=""> - Topik - </option>
                                @foreach($groups as $group)
                                    <option value="{{$group['name']}}" {{request()->get('group') == $group['name'] ? 'selected' : ''}}>{{$group['display_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary btn-split">
                            Cari Data
                            <div class="fab"><span class="mai-play"></span></div>
                        </button>

                        @if(!empty(request()->all()))
                            <a href="{{route('dataset')}}" class="btn btn-outline-danger rounded-3">
                                Reset Pencarian
                                <i class="bi bi-x"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="page-section pt-2">
        <div class="container">
            <div class="row pt-0">
                <div class="col-lg-12">
                    <div class="card wow fadeInUpBig">
                        <div class="card-body">
                            <div class="card-header rounded-3 d-flex justify-content-between align-content-center">
                                <h4 class="card-title">Ditemukan {{count($data)}} dataset</h4>
                                <div class="form-select form-group control-order-by">
                                    <label for="field-order-by">Urutkan hasil</label>
                                    <select id="field-order-by" name="sort" class="form-control">
                                        <option value="score desc, metadata_modified desc" {{request()->get('sort') == 'score desc, metadata_modified desc' ? 'selected' : ''}}>
                                            Relevansi
                                        </option>
                                        <option value="title_string asc" {{request()->get('sort') == 'title_string asc' ? 'selected' : ''}}>Name Ascending</option>
                                        <option value="title_string desc" {{request()->get('sort') == 'title_string desc' ? 'selected' : ''}}>Name Descending</option>
                                        <option value="metadata_modified desc" {{request()->get('sort') == 'metadata_modified desc' ? 'selected' : ''}}>Terakhir Dimodifikasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-stripped wow fadeInDown">
                                    <tbody>
                                    @foreach($data as $d)
                                        <tr>
                                            <td>
                                                <h4><a href="{{config('ckan_api.url')}}dataset/{{$d['name']}}" class="text-primary">{{$d['title']}} <i class="bi bi-link"></i></a></h4> <br>
                                                <p class="text-muted">{{Str::words($d['notes'], 30)}}</p>
                                                @if(!empty($d['organization']))
                                                    <p class="text-muted">
                                                        <i class="bi bi-building"></i>
                                                        <a href="{{url()->current()}}?org={{$d['organization']['name']}}" class="text-muted">{{$d['organization']['title']}}</a>
                                                    </p>
                                                @endif

                                                <div class="">
                                                    @foreach($d['resources'] as $res)
                                                        <span class="badge badge-secondary">{{$res['format']}}</span>
                                                    @endforeach

                                                    <span class="mx-2" title="Tahun data ini dipublikasi"><i class="bi bi-calendar-fill"></i> {{\Carbon\Carbon::parse($d['metadata_created'])->format('Y')}}</span>
                                                    @if(count($d['groups']) > 0)
                                                        <span class="mx-2"><i class="bi bi-tags"></i>
                                                        @foreach($d['groups'] as $group)
                                                            <a href="{{url()->current()}}?group={{$group['name']}}" class="text-muted">{{$group['display_name']}}@if(!$loop->last)</a>, @endif
                                                        @endforeach
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <i class="bi bi-files"></i> {{$d['num_resources']}} berkas
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            const url = new URL(window.location.href);
            $('#field-order-by').on('change', function() {
                url.searchParams.set('sort', $(this).val());
               window.location.href = url.toString();
            });
        });
    </script>
@endpush
