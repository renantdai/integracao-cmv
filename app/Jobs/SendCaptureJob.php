<?php

namespace App\Jobs;

use App\Http\Controllers\Api\RepositoryFtpController;
use App\Models\Capture;
use App\Repositories\IntegrationEloquentORM;
use App\Services\RepositoryFtpService;
use FtpClient\FtpClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCaptureJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $model = new Capture();
        $orm = new IntegrationEloquentORM($model);
        $service = new RepositoryFtpService($orm, new FtpClient);
        $repository = new RepositoryFtpController($service);
        $retorno = $repository->directorySend();
        $count = empty($retorno[0]) ? 0 : count($retorno);
        Log::channel('cron_envio')->debug(now()->format('h:i:s d/m/Y') . ' executou o envio' . 'Registros Enviados: ' . $count);
    }
}
