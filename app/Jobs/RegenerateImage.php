<?php

namespace App\Jobs;

use App\Models\Image;
use App\Notifications\OpenAI\GenerateNotification;
use App\Services\OpenAI\Images\Request;
use App\Services\OpenAI\Images\Result;
use App\Services\OpenAI\OpenAI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegenerateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Image $image;
    protected string $prompt;

    public int $timeout = 180;

    public function __construct(Image $image, string $prompt)
    {
        $this->image = $image;
        $this->prompt = $prompt;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $service = new OpenAI($this->image->user);
        $request = new Request();
        $request->addParams([
            'aspect' => $this->image->aspect->value,
            'quality' => $this->image->quality->value,
            'style' => $this->image->style->value,
            'prompt' => $this->prompt
        ]);
        try {
            DB::beginTransaction();
            $result = $service->imageCreate($request);
            if ($result->success) {
                $this->updateImage($result);
                $result->add('refresh', 'image');
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            $this->image->user->notify(new GenerateNotification([
                'success' => false,
                'debug' => [
                    'component' => 'GenerateImage',
                    'message' => 'Error',
                    'context' => [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'request' => $request->toArray(),
                        'trace' => $e->getTraceAsString()
                    ]
                ]
            ]));
            DB::rollBack();
            throw $e;
        }

        $this->notify($result);
    }

    protected function updateImage(Result $result): void
    {
        $this->image->update([
            'path' => $result->get('path'),
            'prompt' => $this->prompt,
            'attempts' => $this->image->attempts + 1
        ]);
        ScaleImage::dispatch($this->image);
        $result->add('image', $this->image);
    }

    protected function notify(Result $result): void
    {
        $this->image->user->notify(new GenerateNotification($result->toArray()));
        $context = [
            'user' => $this->image->user->only(['id', 'name', 'email']),
            'result' => $result
        ];
        if ($result->success) {
            Log::info('[ReGenerateImage] Done', $context);
        } else {
            Log::warning('[ReGenerateImage] Fail', $context);
        }
    }
}
