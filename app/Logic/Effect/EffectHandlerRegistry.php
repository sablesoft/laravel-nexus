<?php

namespace App\Logic\Effect;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Effect\Definitions\CharacterActionDefinition;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Effect\Definitions\ChatStateDefinition;
use App\Logic\Effect\Definitions\CommentDefinition;
use App\Logic\Effect\Definitions\IfDefinition;
use App\Logic\Effect\Definitions\CharacterStateDefinition;
use App\Logic\Effect\Definitions\MemoryCardDefinition;
use App\Logic\Effect\Definitions\MemoryCreateDefinition;
use App\Logic\Effect\Definitions\ChatRefreshDefinition;
use App\Logic\Effect\Definitions\MergeDefinition;
use App\Logic\Effect\Definitions\PushDefinition;
use App\Logic\Effect\Definitions\ReturnDefinition;
use App\Logic\Effect\Definitions\RunDefinition;
use App\Logic\Effect\Definitions\ScreenBackDefinition;
use App\Logic\Effect\Definitions\ScreenStateDefinition;
use App\Logic\Effect\Definitions\ScreenWaitingDefinition;
use App\Logic\Effect\Definitions\SetDefinition;
use App\Logic\Effect\Definitions\UnsetDefinition;
use App\Logic\Effect\Definitions\ValidateDefinition;
use App\Logic\Effect\Handlers\CharacterActionHandler;
use App\Logic\Effect\Handlers\ChatCompletionHandler;
use App\Logic\Effect\Handlers\ChatStateHandler;
use App\Logic\Effect\Handlers\CommentHandler;
use App\Logic\Effect\Handlers\IfHandler;
use App\Logic\Effect\Handlers\CharacterStateHandler;
use App\Logic\Effect\Handlers\MemoryCardHandler;
use App\Logic\Effect\Handlers\MemoryCreateHandler;
use App\Logic\Effect\Handlers\ChatRefreshHandler;
use App\Logic\Effect\Handlers\MergeHandler;
use App\Logic\Effect\Handlers\PushHandler;
use App\Logic\Effect\Handlers\ReturnHandler;
use App\Logic\Effect\Handlers\RunHandler;
use App\Logic\Effect\Handlers\ScreenBackHandler;
use App\Logic\Effect\Handlers\ScreenStateHandler;
use App\Logic\Effect\Handlers\ScreenWaitingHandler;
use App\Logic\Effect\Handlers\SetHandler;
use App\Logic\Effect\Handlers\UnsetHandler;
use App\Logic\Effect\Handlers\ValidateHandler;
use InvalidArgumentException;

/**
 * Central registry that maps DSL effect keys to their corresponding handler classes.
 * Used at runtime to resolve effect instances based on raw DSL input.
 *
 * Each handler implements `EffectHandlerContract` and contains logic
 * to execute the effect in a given `Process` context.
 *
 * Context:
 * - Populated at boot via `boot()` to register all core handlers.
 * - Used by `EffectRunner` to resolve and run effect handlers dynamically.
 * - DSL key-to-handler mapping mirrors the one in `EffectDefinitionRegistry`.
 */
class EffectHandlerRegistry
{
    protected static array $map = [];

    public static function register(string $key, string $class): void
    {
        self::$map[$key] = $class;
    }

    /**
     * Resolve a handler instance from raw DSL data.
     */
    public static function resolve(array $raw): EffectHandlerContract
    {
        $key = array_key_first($raw);
        $data = $raw[$key];

        if (!isset(self::$map[$key])) {
            throw new InvalidArgumentException("Unknown effect type: [$key]");
        }

        $class = self::$map[$key];

        return new $class($data);
    }

    /**
     * Register all core handlers at boot time.
     */
    public static function boot(): void
    {
        EffectHandlerRegistry::register(IfDefinition::KEY, IfHandler::class);
        EffectHandlerRegistry::register(SetDefinition::KEY, SetHandler::class);
        EffectHandlerRegistry::register(RunDefinition::KEY, RunHandler::class);
        EffectHandlerRegistry::register(PushDefinition::KEY, PushHandler::class);
        EffectHandlerRegistry::register(MergeDefinition::KEY, MergeHandler::class);
        EffectHandlerRegistry::register(UnsetDefinition::KEY, UnsetHandler::class);
        EffectHandlerRegistry::register(ReturnDefinition::KEY, ReturnHandler::class);
        EffectHandlerRegistry::register(CommentDefinition::KEY, CommentHandler::class);
        EffectHandlerRegistry::register(ValidateDefinition::KEY, ValidateHandler::class);
        EffectHandlerRegistry::register(ChatStateDefinition::KEY, ChatStateHandler::class);
        EffectHandlerRegistry::register(MemoryCardDefinition::KEY, MemoryCardHandler::class);
        EffectHandlerRegistry::register(ScreenBackDefinition::KEY, ScreenBackHandler::class);
        EffectHandlerRegistry::register(ScreenStateDefinition::KEY, ScreenStateHandler::class);
        EffectHandlerRegistry::register(ChatRefreshDefinition::KEY, ChatRefreshHandler::class);
        EffectHandlerRegistry::register(MemoryCreateDefinition::KEY, MemoryCreateHandler::class);
        EffectHandlerRegistry::register(ScreenWaitingDefinition::KEY, ScreenWaitingHandler::class);
        EffectHandlerRegistry::register(CharacterStateDefinition::KEY, CharacterStateHandler::class);
        EffectHandlerRegistry::register(ChatCompletionDefinition::KEY, ChatCompletionHandler::class);
        EffectHandlerRegistry::register(CharacterActionDefinition::KEY, CharacterActionHandler::class);
    }
}
