<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\Image;
use App\Services\OpenAI;
use App\Services\OpenAI\Images\Request;
use App\Services\OpenAI\Images\Result;
use App\Notifications\OpenAI\GenerateNotification;

class GenerateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Request $request;
    protected User $user;
    protected ?string $title;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, User $user, ?string $title = null)
    {
        $this->request = $request;
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $service = new OpenAI($this->user);
            $result = $service->imageCreate($this->request);
            $result->add('route', 'images');
            if ($result->success) {
                $this->createImage($result);
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            $this->user->notify(new GenerateNotification([
                'success' => false,
                'route' => 'images'
            ], $this->user->id));
            DB::rollBack();
            throw $e;
        }
        $this->notify($result);
    }

    /**
     * @param Result $result
     * @return void
     */
    protected function createImage(Result $result): void
    {
        $image = Image::create([
            'path' => $result->get('path'),
            'title' => $this->title,
            'prompt' => $this->request->getParam('prompt'),
            'user_id' => $this->user->id
        ]);
        $result->add('image', $image);
    }

    /**
     * @param Result $result
     * @return void
     */
    protected function notify(Result $result): void
    {
        $this->user->notify(new GenerateNotification($result->toArray(), $this->user->id));
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
