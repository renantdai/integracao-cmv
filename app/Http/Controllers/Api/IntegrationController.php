<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTO\CreateCaptureDTO;
use App\Services\IntegrationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CaptureResource;


class IntegrationController extends Controller {
    public function __construct(
        protected IntegrationService $service,
    ) {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function capture(Request $request) {
        //validar dados
        $dto = CreateCaptureDTO::makeFromRequest($request);
        $this->show($dto->place);


        //enviar dados
        $capture = $this->service->new($dto);


        //retorno
        return (new CaptureResource($capture))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$place = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CaptureResource($place);
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
