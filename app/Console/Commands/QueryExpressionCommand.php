<?php

namespace App\Console\Commands;

use App\Logic\Dsl\QueryExpressionParser;
use App\Models\Memory;
use Illuminate\Console\Command;

class QueryExpressionCommand extends Command
{
    protected $signature = 'dsl:query
                            {expression : DSL-выражение для фильтрации}
                            {--raw : Показать SQL запроса}
                            {--count : Показать только количество}
                            {--limit=10 : Ограничение результатов}';

    protected $description = 'Протестировать DSL-выражение на модели Memory';

    public function handle(): int
    {
        $expression = $this->argument('expression');
        $limit = (int) $this->option('limit');
        $showRaw = $this->option('raw');
        $onlyCount = $this->option('count');

        $parser = new QueryExpressionParser();
        $query = $parser->apply(Memory::query(), $expression);

        if ($showRaw) {
            dump($query->toSql(), $query->getBindings());
            return self::SUCCESS;
        }

        if ($onlyCount) {
            $this->info('Count: ' . $query->count());
            return self::SUCCESS;
        }

        $results = $query->limit($limit)->get();
        $this->table(
            ['id', 'chat_id', 'member_id', 'type', 'title', 'content'],
            $results->map(fn ($m) => [
                $m->id, $m->chat_id, $m->member_id, $m->type, $m->title, str($m->content)->limit(40),
            ])
        );

        return self::SUCCESS;
    }
}

