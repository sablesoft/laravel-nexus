<?php

namespace App\Services\OpenAI\Images;

use App\Services\OpenAI\Enums\ImageAspect;
use App\Services\OpenAI\Enums\ImageQuality;
use App\Services\OpenAI\Enums\ImageStyle;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Log;

class Request extends \App\Services\OpenAI\Request implements Arrayable
{
    /**
     * @throws Exception
     */
    public function addParams(array $params): self
    {
        $this->validate($params);
        foreach (['prompt', 'style', 'quality', 'aspect', 'size'] as $param) {
            $this->addParam($param, $params[$param]);
        }

        return $this;
    }

    /**
     * @param array $params
     * @return void
     * @throws Exception
     */
    protected function validate(array &$params): void
    {
        if (empty($params['prompt'])) {
            $message = 'Prompt required for image creation';
            Log::error('[OpenAI][Images][Request] ' . $message, [
                'params' => $params
            ]);
            throw new Exception($message);
        }
        $selects = [
            'aspect' => ImageAspect::values(),
            'quality' => ImageQuality::values(),
            'style' => ImageStyle::values()
        ];
        $defaults = [
            'aspect' => ImageAspect::getDefault()->value,
            'quality' => ImageQuality::getDefault()->value,
            'style' => ImageStyle::getDefault()->value,
        ];
        foreach ($selects as $select => $options) {
            if (!isset($params[$select])) {
                $params[$select] = $defaults[$select];
            } elseif (!in_array($params[$select], $options)) {
                $error = 'Invalid option for image creation';
                Log::error('[OpenAI][Images][Request] ' . $error, [
                    'params' => $params,
                    'select' => $select
                ]);
                throw new Exception($error);
            }
        }
        $aspect = $params['aspect'];
        $size = ImageAspect::from($aspect)->getSize();
        $params['size'] = $size;
        $this->addParam('original_prompt', $params['prompt']);
        $params['prompt'] = $params['prompt'] .
            " [Aspect ratio: $aspect, $size".
            "; Style: ". $params['style'].
            "; Quality: " . $params['quality'] ."]";
    }

    public function toArray(): array
    {
        $params = parent::toArray();
        unset($params['aspect'], $params['original_prompt']);

        return $params;
    }
}
