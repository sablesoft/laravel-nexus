<?php

namespace App\Logic;

use App\Logic\Contracts\LogicContract;
use App\Logic\Facades\LogicRunner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class LogicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $pack;
    protected string $logicDescriptor;

    public int $timeout = 300;

    public function __construct(LogicContract $logic, Process $process)
    {
        $this->pack = $process->pack();
        $this->logicDescriptor = $this->packLogic($logic);
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        logger()->debug('[LogicJob][Start]', [
            'pack' => $this->pack,
            'logic' => $this->logicDescriptor
        ]);
        $process = Process::unpack($this->pack);
        $logic = $this->unpackLogic($this->logicDescriptor);

        try {
            DB::beginTransaction();
            $process->inQueue = true;
            LogicRunner::runLogic($logic, $process);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            $this->notifyError($e, $process);
            throw $e;
        }

        $this->notifySuccess($process);
    }

    protected function packLogic(LogicContract $logic): string
    {
        if (method_exists($logic, 'getKey')) {
            return get_class($logic) . ':' . $logic->getKey();
        }

        return get_class($logic);
    }

    protected function unpackLogic(string $descriptor): LogicContract
    {
        if (str_contains($descriptor, ':')) {
            /** @var Model|LogicContract $class */
            [$class, $id] = explode(':', $descriptor, 2);
            if (class_exists($class) && is_subclass_of($class, LogicContract::class)) {
                return $class::findOrFail($id);
            }

            throw new \InvalidArgumentException('Invalid logic descriptor: ' . $descriptor);
        }

        return app($descriptor);
    }

    protected function notifySuccess(Process $process): void
    {
        logger()->debug('[LogicJob][Finish]', [
            'pack' => $this->pack,
            'process' => $process->pack(),
            'logic' => $this->logicDescriptor
        ]);
        // todo - notify by chat, member
    }

    protected function notifyError(Throwable $e, Process $process): void
    {
        logger()->error('[LogicJob][Error]' . $e->getMessage(), [
            'pack' => $this->pack,
            'process' => $process->pack(),
            'logic' => $this->logicDescriptor
        ]);
        // todo - notify by chat, member
    }
}
