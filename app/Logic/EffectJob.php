<?php

namespace App\Logic;

use App\Logic\Facades\EffectRunner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class EffectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $pack;
    protected string $effectKey;
    protected array $params;

    public function __construct(string $effectKey, array $params, Process $process)
    {
        $this->effectKey = $effectKey;
        $this->params = $params;
        $this->pack = $process->pack();
    }

    public function handle(): void
    {
        $process = Process::unpack($this->pack);

        try {
            EffectRunner::run([
                [$this->effectKey => $this->params]
            ], $process);
        } catch (Throwable $e) {
            Log::error("[EffectJob] Failed to run async effect: {$this->effectKey}", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'params' => $this->params,
                'process' => $process->pack(),
            ]);
        }
    }
}
