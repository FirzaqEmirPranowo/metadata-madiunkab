<ul class="nav nav-tabs nav-tabs-bordered d-flex text-center" id="borderedTabJustified" role="tablist">
    <li class="nav-item flex-fill" role="presentation">
        <a class="nav-link w-100 {{request()->routeIs('publikasi.organisasi') ? 'active' : ''}}" id="org-tab" data-bs-toggle="tab" data-bs-target="#tab-org" type="button" role="tab">
            <i class="bi bi-building"></i> Organisasi
        </a>
    </li>
    <li class="nav-item flex-fill" role="presentation">
        <a class="nav-link w-100" id="data-tab" data-bs-toggle="tab"
           data-bs-target="#tab-data" type="button" role="tab">
           <i class="bi bi-sim"></i> Informasi Dataset
        </a>
    </li>

    <li class="nav-item flex-fill" role="presentation">
        <a class="nav-link w-100" id="berkas-tab" data-bs-toggle="tab"
           data-bs-target="#tab-berkas" type="button" role="tab">
           <i class="bi bi-file-zip"></i> Berkas
        </a>
    </li>

</ul>
