<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\User;
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

class GenerateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Request $request;
    protected User $user;
    protected ?string $title;

    public int $timeout = 180;

    public function __construct(Request $request, User $user, ?string $title = null)
    {
        $this->request = $request;
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $service = new OpenAI($this->user);
            $result = $service->imageCreate($this->request);
            if ($result->success) {
                $this->createImage($result);
                $result->add('refresh', 'image');
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            $this->user->notify(new GenerateNotification([
                'success' => false,
                'debug' => [
                    'component' => 'GenerateImage',
                    'message' => 'Error',
                    'context' => [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'request' => $this->request->toArray(),
                        'trace' => $e->getTraceAsString()
                    ]
                ]
            ]));
            DB::rollBack();
            throw $e;
        }
        $this->notify($result);
    }

    protected function createImage(Result $result): void
    {
        $image = Image::create([
            'path' => $result->get('path'),
            'title' => $this->title,
            'prompt' => $this->request->getParam('original_prompt'),
            'user_id' => $this->user->id,
            'aspect' => $this->request->getParam('aspect'),
            'quality' => $this->request->getParam('quality'),
            'style' => $this->request->getParam('style')
        ]);
        ScaleImage::dispatch($image);
        $result->add('image', $image);
    }

    protected function notify(Result $result): void
    {
        $this->user->notify(new GenerateNotification($result->toArray()));
        $context = [
            'user' => $this->user->only(['id', 'name', 'email']),
            'result' => $result
        ];
        if ($result->success) {
            Log::info('[GenerateImage] Done', $context);
        } else {
            Log::warning('[GenerateImage] Fail', $context);
        }
    }
}
