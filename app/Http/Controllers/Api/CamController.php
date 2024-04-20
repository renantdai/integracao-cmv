<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTO\CreateCamDTO;
use App\Http\Requests\SendCamRequest;
use App\Models\Cam;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCamRequest;
use App\Services\CamService;
use Illuminate\Http\Response;

class CamController extends Controller {
    public function __construct(
        protected CamService $service
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCamRequest $request) {
        $dto = CreateCamDTO::makeFromRequest($request);
        $cam = $this->service->new($dto);

        if (!$cam->id) {
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
                'cam' => $cam,
            ], Response::HTTP_CREATED);
        }

        return $send;
    }

    /**
     * Display the specified resource.
     */
    public function show(Cam $cam) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cam $cam) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cam $cam) {
        //
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
