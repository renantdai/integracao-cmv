<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CreateCamDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCamRequest;
use App\Services\CamService;
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

    public function send(string $id) {
        $retorno = $this->service->send($id);

        if ($retorno['error']) {
            return redirect()
                ->route('cams.index')
                ->with('message', $retorno['msg']);
        }

        return redirect()
            ->route('cams.index')
            ->with('message', 'Enviado com Sucesso!');
    }
}
