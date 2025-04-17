<?php

namespace App\Logic\Contracts;

use App\Logic\Process;
use Illuminate\Support\Collection;

/**
 * LogicContract defines the interface for any executable logic unit
 * composed of a sequence of logic nodes (NodeContract), and intended to be part of a larger execution process.
 *
 * In practice, it is currently implemented only by the Scenario model.
 * It allows determining whether the logic should be executed immediately or via queue (shouldQueue),
 * and provides the list of nodes to execute (getNodes).
 * It also inherits from HasEffectsContract and therefore supports before/after DSL instruction blocks.
 *
 * ---
 * Context:
 * - Executed by LogicRunner either directly or via NodeRunner
 * - May be queued via LogicJob if shouldQueue returns true
 */
interface LogicContract extends HasEffectsContract
{
    /**
     * Returns the collection of logic nodes (NodeContract) to be executed as part of this logic.
     *
     * @return Collection<int, NodeContract>
     */
    public function getNodes(): Collection;
}
