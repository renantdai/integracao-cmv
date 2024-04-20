<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CreateCamDTO;
use App\DTO\Supports\CreateSupportDTO;
use App\DTO\Supports\UpdateSupportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCamRequest;
use App\Http\Requests\StoreUpdateSupport;
use App\Models\Cam;
use App\Services\CamService;
use App\Services\SupportService;
use Illuminate\Http\Request;

class CamController extends Controller {
    public function __construct(protected CamService $service) {
    }

    public function index(Request $request) {

        $cams = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 5),
            filter: $request->filter,
        );

        $filters = ['filter' => $request->get('filter', '')];

        return view('admin/cams/index', compact('cams', 'filters'));
    }

    public function create() {
        return view('admin/cams/create');
    }

    public function store(StoreCamRequest $request) {
        $this->service->new(CreateCamDTO::makeFromRequest($request));

        return redirect()
            ->route('cams.index')
            ->with('message', 'Cadastrado com sucesso!');
    }

    public function show(string|int $id) {
        if (!$cam = $this->service->findOne($id)) {
            return back();
        }
        return view('admin/cams/show', compact('cam'));
    }

    public function edit(string $id) {
        if (!$cam = $this->service->findOne($id)) {
            return back();
        }
        return view('admin/cams/edit', compact('cam'));
    }
}
