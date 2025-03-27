<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\CommandContract;
use App\Logic\Contracts\LogicRunnerContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Contracts\ScenarioContract;
use App\Logic\Process;

class LogicRunner
{
    public function run(NodeContract $node, Process $process): void
    {
        if ($runner = $this->nodeRunner($node)) {
            $runner->run($process);
        }
    }

    public function runCommand(CommandContract $command, Process $process): void
    {
        $this->commandRunner($command)->run($process);
    }

    public function runScenario(ScenarioContract $scenario, Process $process): void
    {
        $this->scenarioRunner($scenario)->run($process);
    }

    protected function nodeRunner(NodeContract $node): ?LogicRunnerContract
    {
        if ($command = $node->getCommand()) {
            return $this->commandRunner($command);
        }

        if ($scenario = $node->getScenario()) {
            return $this->scenarioRunner($scenario);
        }

        return null;
    }

    protected function commandRunner(CommandContract $command): LogicRunnerContract
    {
        return new CommandRunner($command);
    }

    protected function scenarioRunner(ScenarioContract $scenario): LogicRunnerContract
    {
        return new ScenarioRunner($scenario);
    }
}
