<?php

namespace App\Services\OpenAI\Images;

use Exception;
use Throwable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use OpenAI\Responses\Images\CreateResponse;

class Result extends \App\Services\OpenAI\Result
{
    /**
     * @param CreateResponse $response
     * @return void
     * @throws Throwable
     */
    public function handle(CreateResponse $response): void
    {
        $data = $response->data[0] ?? [];
        if (!$imageUrl = $data['url'] ?? null) {
            $this->markFailed();
            throw new Exception('Image url not found!');
        }

        $client = new Client();
        $response = $client->get($imageUrl);
        if ($response->getStatusCode() !== 200) {
            $this->markFailed();
            throw new Exception('Failed to download image from ' . $imageUrl);
        }
        $imageContent = $response->getBody()->getContents();
        $imageName = basename(parse_url($imageUrl, PHP_URL_PATH));
        $path = 'public/images/' . $imageName;
        Storage::put($path, $imageContent);
        $this->add('path', $path);
        $this->markSuccess();
    }
}
