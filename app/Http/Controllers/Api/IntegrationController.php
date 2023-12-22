<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTO\CreateCaptureDTO;
use App\Services\IntegrationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CaptureResource;
use Illuminate\Support\Facades\Log;

class IntegrationController extends Controller {
    public function __construct(
        protected IntegrationService $service,
    ) {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function capture(Request $request) {
        Log::info('Recebido a requisicao', ['id' => $request->id]);
        $dto = CreateCaptureDTO::makeFromRequest($request);

        $validate = $this->service->validateStatus($dto);
        if (!$validate) {
            return response()->json([
                'error' => true,
                'msg' => 'Placa já se encontrada transmitida para o CMV ou não foi enviado a imagem'
            ], Response::HTTP_OK);
        }

        Log::info('Estou antes de enviar', ['id' => $request->id]);

        $capture = $this->service->new($dto);
        $dto->id = $capture->id;

        Log::info('Estou depois de enviar', ['id' => $request->id]);

        $sent = $this->service->envioLeituraService($dto);

        if (!$sent) {
            Log::info('Estou no erro', ['id' => $request->id]);
            return response()->json([
                'error' => true,
                'msg' => 'Não foi possivel transmitir para o CMV, a requisição ficará na fila de transmissão'
            ], Response::HTTP_ACCEPTED);
        }
        $dto->statusSend = $dto::SENT;

        return (new CaptureResource($capture))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        if (!$plate = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CaptureResource($plate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
