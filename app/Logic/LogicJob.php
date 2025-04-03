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

/**
 * LogicJob is responsible for executing user-defined logic in the background via the queue system.
 * It is the central mechanism for deferred execution of Scenarios, Steps, Nodes, and other
 * LogicContract-based structures.
 *
 * When the job is created, it serializes the Process and stores a reference to the logic object
 * as a descriptor string. During queue execution, the job restores both the Process and the logic,
 * and runs the logic via LogicRunner.
 *
 * Currently, only stateful logic (Eloquent models with an ID) is supported.
 *
 * ---
 * Context:
 * - Triggered from LogicRunner::runLogic if logic needs to be deferred (shouldQueue = true)
 * - Serializes and deserializes the Process object while preserving DSL context and timing
 * - In the future, will dispatch a logic failure event so subscribers can notify relevant users (members, authors, admins) or take other actions
 */
class LogicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $pack; // Serialized Process
    protected string $logicDescriptor; // Logic reference (e.g. App\Models\Scenario:15)

    public int $timeout = 300;

    public function __construct(LogicContract $logic, Process $process)
    {
        $this->pack = $process->pack();
        $this->logicDescriptor = $this->packLogic($logic);
    }

    /**
     * Main job handler.
     * Unpacks the process and logic, and executes them using LogicRunner inside a DB transaction.
     *
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
            $this->handleError($e, $process);
            throw $e;
        }

        logger()->debug('[LogicJob][Finish]', [
            'pack' => $this->pack,
            'process' => $process->pack(),
            'logic' => $this->logicDescriptor
        ]);
    }

    /**
     * Converts the logic instance to a descriptor string.
     * Currently supports only Eloquent models (class:ID format).
     */
    protected function packLogic(LogicContract $logic): string
    {
        if (method_exists($logic, 'getKey')) {
            return get_class($logic) . ':' . $logic->getKey();
        }

        return get_class($logic);
    }

    /**
     * Restores a LogicContract instance from a descriptor string.
     * Supports only Eloquent models with a primary key.
     *
     * @throws \InvalidArgumentException
     */
    protected function unpackLogic(string $descriptor): LogicContract
    {
        if (!str_contains($descriptor, ':')) {
            throw new \InvalidArgumentException('Invalid logic descriptor: ' . $descriptor);
        }

        /** @var Model|LogicContract $class */
        [$class, $id] = explode(':', $descriptor, 2);
        if (class_exists($class) && is_subclass_of($class, LogicContract::class)) {
            return $class::findOrFail($id);
        }

        throw new \InvalidArgumentException('Invalid logic descriptor: ' . $descriptor);
    }

    /**
     * Logs and handles errors during logic execution.
     * In the future, this method will dispatch an error event.
     */
    protected function handleError(Throwable $e, Process $process): void
    {
        logger()->error('[LogicJob][Error]' . $e->getMessage(), [
            'pack' => $this->pack,
            'process' => $process->pack(),
            'logic' => $this->logicDescriptor
        ]);

        // todo - dispatch event, notify member, chat, author, admins, etc.
        // LogicProcessFailed::dispatch
    }
}
