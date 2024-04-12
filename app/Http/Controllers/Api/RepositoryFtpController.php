<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFtpService;
use Illuminate\Http\Request;

class RepositoryFtpController extends Controller {
    public function __construct(
        protected RepositoryFtpService $service,
    ) {
    }

    public function testarConexao(Request $request) {
        return $this->service->testConnectionFtp($request->host, $request->user, $request->password, $request->port);
    }

    public function testarConexaoPHP(Request $request) {
        return $this->service->testConnectionFtpPHP($request->host, $request->user, $request->password);
    }

    public function verificaRepositorio() {
        return $this->service->verificaRepositorio();
    }

    public function verificaRepositorioFtp(Request $request) {
        $this->service->diretory = $request->directory;

        return $this->service->verificaRepositorio();
    }

    public function verificaRepositorioSftp(Request $request) {
        $this->service->diretory = $request->directory;

        return $this->service->verificaRepositorioSftp();
    }
    /**
     * Display the specified resource.
     */
    public function show() {
        return $this->service->show();
    }
}
