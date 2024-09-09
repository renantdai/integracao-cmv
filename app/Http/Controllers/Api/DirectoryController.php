<?php

namespace App\Http\Controllers\Api;

use App\DTO\CreateDirectoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCamRequest;
use App\Http\Requests\StoreDirectoryRequest;
use App\Services\DirectoryService;
use Illuminate\Http\Request;

class DirectoryController extends Controller {
    public function __construct(protected DirectoryService $service) {
    }

    public function store(StoreDirectoryRequest $request) {
        return $this->service->new(CreateDirectoryDTO::makeFromRequest($request));
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

    public function certificado(Request $request) {
        if (!$request->certificado) {
            return ['error' => true, 'msg' => 'não há certificado na requisição'];
        }

        return $this->service->certificado($request->certificado);
    }
}
