<?php

namespace App\Logic\Contracts;

/**
 * NodeContract defines the contract for a "logic node" — a fundamental executable unit
 * that may be part of a larger logic structure (LogicContract), such as a scenario step (Step),
 * or an interactive screen control (Control, Transfer).
 *
 * Each node can include its own before/after blocks (inherited from HasEffectsContract)
 * which contain user-defined DSL instructions, and may also contain embedded logic (via getLogic),
 * which will be executed by the LogicRunner.
 *
 * ---
 * Context:
 * - Implemented by entities such as Step, Control, and Transfer
 * - Executed through NodeRunner
 * - Supports logic nesting through getLogic, allowing users to embed and reuse any prepared logic
 *   scenarios across various parts of their application
 */
interface NodeContract extends HasEffectsContract
{
    /**
     * Returns the embedded logic, if the node contains any (e.g., Step wrapping a Scenario).
     * Can return null if no logic is defined for this node.
     */
    public function getLogic(): ?LogicContract;
}
