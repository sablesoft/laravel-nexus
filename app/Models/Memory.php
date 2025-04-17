<?php

namespace App\Models;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Dsl\Adapters\MemoryDslAdapter;
use App\Logic\Process;
use Carbon\Carbon;
use Database\Factories\MemoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Memory model represents a unit of stored chat information,
 * generated by chat participants, scenarios, language models, or the system itself.
 * It is used for all possible purposes within the application — from user messages,
 * to various elements of game content (e.g. items, characters, locations, events, quests)
 * for game-based apps, and also as a long-term storage of various states of the chat
 * and all its logical components. Each Memory is always linked to a Chat,
 * and can optionally be linked to an author participant, a target participant, and an image.
 *
 * It supports an arbitrary `type` and `meta` field, which can be used for application-specific
 * logic and filtered using DSL expressions defined at the screen level.
 *
 * Implements HasDslAdapterContract, making it accessible in DSL expressions when used
 * as a context-bound model. Returns an instance of MemoryDslAdapter.
 *
 * Environment:
 * - Used in Chat\Play as the primary message source (`memories`)
 * - Filtered via Dsl::apply(...) using the current screen’s query (`screen.query`)
 * - Can be used in DSL expressions (e.g. memory.create(type, data))
 * - Can display an image, either uploaded or generated by the user or a scenario
 *
 * @property null|int $id
 * @property null|int $chat_id      - ID of the chat to which this record belongs
 * @property null|int $author_id    - ID of the character who created this record
 * @property null|int $character_id - ID of the character this record is addressed to
 * @property null|int $image_id     - ID of the image attached to this record
 * @property null|string $title     - Optional title of the record
 * @property null|string $content   - Main textual content
 * @property null|string $language  - Memory language
 * @property null|string $type      - Type of the record (e.g. screen code or any custom type: 'log', 'message', 'item', 'location', etc.)
 * @property null|array $meta       - Arbitrary metadata stored as jsonb
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat           - Associated chat
 * @property-read null|Character $author    - Character who created the record
 * @property-read null|Character $character - Character the record is addressed to
 * @property-read null|Image $image         - Attached image (if any)
 */
class Memory extends Model implements HasDslAdapterContract
{
    /** @use HasFactory<MemoryFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id', 'character_id', 'chat_id', 'image_id', 'title', 'content', 'type', 'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'author_id');
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function getDslAdapter(Process $process): DslAdapterContract
    {
        return new MemoryDslAdapter($process, $this);
    }

    /**
     * @param Collection<int, Memory> $memories
     * @return array
     */
    public static function toMessages(Collection $memories): array
    {
        $messages = [];
        /** @var Memory $memory */
        foreach($memories as $memory) {
            $data[] = $memory->content;
            $data[] = $memory->meta ? 'Meta: ' . json_encode($memory->meta) : '';
            $messages[] = [
                'role' => $memory->author_id ? 'user' : 'assistant',
                'content' => implode(' ', $data)
            ];
        }
        return $messages;
    }
}
