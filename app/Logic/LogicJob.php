<?php

namespace App\Logic;

use App\Logic\Contracts\LogicContract;
use App\Logic\Facades\LogicRunner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class LogicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected LogicContract $logic;
    protected Process $process;

    public int $timeout = 300;

    public function __construct(LogicContract $logic, Process $process)
    {
        $this->logic = $logic;
        $this->process = $process;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $this->process->inQueue = true;
            LogicRunner::runLogic($this->logic, $this->process);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            $this->notifyError($e);
            throw $e;
        }

        $this->notifySuccess();
    }

    protected function notifySuccess(): void
    {
        // todo - notify by process
    }

    protected function notifyError(Throwable $e): void
    {
        // todo
    }
}
