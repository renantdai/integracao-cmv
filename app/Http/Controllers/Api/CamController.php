<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTO\CreateCamDTO;
use App\Http\Requests\SendCamRequest;
use App\Models\Cam;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCamRequest;
use App\Services\CamService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CamController extends Controller {
    public function __construct(
        protected CamService $service
    ) {
    }

    public function store(StoreCamRequest $request) {
        try {
            $dto = CreateCamDTO::makeFromRequest($request);
            $cam = $this->service->new($dto);

            if (!isset($cam->id)) {
                return response()->json([
                    'error' => 'true',
                    'msg' => 'Não foi possivel cadastrar a camera'
                ], Response::HTTP_OK);
            }

            $send = $this->service->sendPrepare($cam->id, $dto);
            if (is_null($send)) {
                return response()->json([
                    'warning' => 'true',
                    'error' => 'true',
                    'msg' => 'Não foi possivel transmitir para o CMV, a requisição ficará na fila de transmissão',
                    'cam' => $cam->id,
                ], Response::HTTP_CREATED);
            }

            return $send;
        } catch (Exception $e) {
            Log::channel('camlog')->debug('Erro ao receber uma nova camera: ' . $e->getMessage(), [$request->all()]);

            return response()->json([
                'error' => 'true',
                'msg' => 'Erro ao receber uma nova camera: ' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function send(SendCamRequest $request) {
        $return = $this->service->send($request->id);

        if ($return['error']) {
            return response()->json([
                'error' => 'true',
                'id' => $request->id,
                'msg' => $return['msg'],
                'cStat' => isset($return['cStat']) ? $return['cStat'] : '0'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $return;
    }
}
