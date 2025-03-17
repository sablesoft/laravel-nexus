<?php

namespace App\Services\OpenAI\Images;

use App\Services\OpenAI\Enums\ImageAspect;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Log;

class Request extends \App\Services\OpenAI\Request implements Arrayable
{
    const DEFAULT_SIZE = '1024x1024';
    const DEFAULT_QUALITY = 'standard';
    const DEFAULT_STYLE = 'vivid';

    /**
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function addParams(array $params): self
    {
        $this->validate($params);
        foreach (['prompt', 'style', 'quality'] as $param) {
            $this->addParam($param, $params[$param]);
        }
        $aspect = $params['aspect'] ?? ImageAspect::getDefault()->value;
        $this->addParam('size', ImageAspect::from($aspect)->getSize());

        return $this;
    }

    /**
     * @return string[]
     */
    public static function qualities(): array
    {
        return [
            'standard' => 'Standard',
            'hd' => 'HD'
        ];
    }

    /**
     * @return string[]
     */
    public static function styles(): array
    {
        return [
            'vivid' => 'Vivid',
            'natural' => 'Natural'
        ];
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
            'quality' => array_keys(self::qualities()),
            'style' => array_keys(self::styles())
        ];
        $defaults = [
            'aspect' => ImageAspect::getDefault(),
            'quality' => self::DEFAULT_QUALITY,
            'style' => self::DEFAULT_STYLE,
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
    }
}
