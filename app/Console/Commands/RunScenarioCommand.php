<?php

namespace App\Console\Commands;

use App\Logic\Facades\LogicRunner;
use App\Logic\Process;
use App\Models\Scenario;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RunScenarioCommand extends Command
{
    protected $signature = 'scenario:run {code} {--param=*}';
    protected $description = 'Run a scenario by its code with optional input parameters';

    public function handle(): int
    {
        $code = $this->argument('code');
        $params = $this->option('param');

        /** @var Scenario|null $scenario */
        $scenario = Scenario::query()->where('code', $code)->first();

        if (!$scenario) {
            $this->error("Scenario with code [$code] not found.");
            return Command::FAILURE;
        }

        $input = [];
        foreach ($params as $item) {
            if (!Str::contains($item, '=')) continue;
            [$key, $value] = explode('=', $item, 2);
            $input[$key] = $value;
        }

        $this->info("Running scenario: {$scenario->title} ({$scenario->code})");

        $process = new Process($input);
        $process->skipQueue = true;

        $this->line('---');
        $this->info('Process dump before:');
        dump($process->toArray());

        LogicRunner::runLogic($scenario, $process);

        $this->line('---');
        $this->info('Process dump after:');
        dump($process->toArray());

        return Command::SUCCESS;
    }
}
