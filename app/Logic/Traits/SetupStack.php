<?php

namespace App\Logic\Traits;

use App\Logic\Contracts\SetupContract;

trait SetupStack
{
    public array $setupStack = [];
    public array $logs = [];
    public int $maxStack = 50;

    public function startLog(SetupContract $setup): void
    {
        $code = $setup->getCode();
        if (in_array($code, $this->setupStack)) {
            throw new \RuntimeException("Recursive setup detected: $code, stack: ". implode(', ', $this->setupStack));
        }
        logger()->debug('[Logic][Setup][Start] '. $setup::class .':'.
            $setup->getCode() .'| Level: '. count($this->setupStack));
        $this->logs[] = [
            'code' => $setup->getCode(),
            'status' => 'started',
            'depth' => count($this->setupStack)
        ];
        $this->setupStack[] = $code;

        if ($this->isOverflow()) {
            throw new \RuntimeException("Setup stack overflow");
        }
    }

    public function finishLog(SetupContract $setup): void
    {
        logger()->debug('[Logic][Setup][Finish] '. $setup::class .':'.
            $setup->getCode() .'| Level: '. count($this->setupStack));
        $this->logs[] = [
            'code' => array_pop($this->setupStack),
            'status' => 'finished',
            'depth' => count($this->setupStack)
        ];
    }

    public function isOverflow(): bool
    {
        return count($this->setupStack) > $this->maxStack;
    }
}
