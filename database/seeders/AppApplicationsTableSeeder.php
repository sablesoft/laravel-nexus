<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppApplicationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.applications')->delete();
        
        \DB::table('app.applications')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'image_id' => 51,
                'title' => '{"en":"After People","ru":"После Людей"}',
                'description' => '{"en":"Humanity is gone — or nearly so. An unknown and unbeatable virus, called the Doomsday Virus, spared flora and fauna, but wiped out nearly all humans. Among the rare survivors, two small groups emerged: the Walkers — natural immunes who roam freely through the ruins of civilization with uncovered faces, and the Shells — those who hide behind a shield of technology, clinging to the past and trying to reclaim it.\\n\\nThis story unfolds in the silence left behind. In forests where trees have reclaimed the land, and in cities swallowed by green, you will be one of the last. Or the first? One way or another, life goes on. In the years of collapse, the past has grown wild with rumors and legends. Can the truth still be found? And does it even matter?\\n\\nYour choices, discoveries, and fears will shape not only your path — but whether you remain human. Perhaps even the fate of the world rests in your hands. Many events are dynamically generated, shaped by your character, your past, and the world\'s stubborn memory.\\n\\nWhat you find among the ruins will change you. Or break you.","ru":"Человечество исчезло — или почти. Неизвестный и непобедимый вирус, названный Вирусом Судного Дня, обошёл стороной флору и фауну, но истребил людей. Среди редких выживших сформировались две малочисленные группы: Странники — естественные иммуны, свободно странствующие по руинам былой цивилизации с открытым лицом, и Панцири — те, кто прячутся от враждебной для них среды за щитом технологий и пытаются вернуть былые времена.\\n\\nЭта история разворачивается в тишине, оставшейся после. В лесах, где деревья отвоевали землю, и в городах, поглощённых зеленью, ты будешь одним из последних. Или первых? Ведь так или иначе, жизнь продолжается. За время разрухи прошлое обросло множеством слухов и легенд. Удастся ли теперь отыскать правду? Да и нужно ли это?\\n\\nТвои выборы, находки и страхи определят не только маршрут — но и то, останешься ли ты человеком. А может оказаться, что и судьба всего этого мира в твоих руках. Многие события генерируется динамически, в зависимости от твоего персонажа, прошлого и упрямой памяти этого мира.\\n\\nТо, что ты найдёшь среди руин, изменит тебя. Или сломает."}',
                'is_public' => true,
                'seats' => 1,
                'states' => '{"has": {"time": {"type": "enum", "value": "dawn", "options": ["dawn", "morning", "late_morning", "noon", "afternoon", "sunset", "evening", "night", "midnight", "late_night", "pre_dawn"]}, "weather": {"type": "enum", "value": "clear", "options": ["clear", "warm_breeze", "hazy", "cloudy", "overcast", "light_rain", "heavy_rain", "storm", "fog", "humid", "cold_drizzle", "frost", "snow", "blizzard"]}}}',
                'character_states' => NULL,
                'behaviors' => NULL,
            'init' => '[{"comment":">>Prepare weather and time"},{"chat.state":{"weather":"chat.randomState(\'weather\')","time":"chat.randomState(\'time\')"}}]',
            'before' => '[{"set":{"doomsday_virus":">>Doomsday Virus \\u2014 a fast-spreading anomaly that wiped out most of humanity within weeks. Scientists never found a cure, or even an explanation. It affects only humans; animals and plants were untouched. That alone gave rise to hundreds of theories: from divine reset to elite-engineered collapse","fractions":">>Walkers and Shells \\u2014 all survivors are loosely divided into these two groups. They mistrust one another and sometimes openly clash. Their fundamental difference lies in the fact that the Walkers possess natural immunity, while the Shells do not","character_info":[{"role":">>system","content":">>User plays a text-based survival game in a post-apocalyptic world. Always consider (and explain as much as possible) the following information when preparing your response: time of day: {{ chat.state(\'time\') }}; weather: {{ chat.state(\'weather\') }}; user\'s character: {{ character.asString }}"},{"role":">>system","content":">>The user\'s character speaks {{ character.language }} and identifies as {{ character.gender }}. Always respond in this language unless instructed otherwise and always use grammatical forms that match the character\'s gender. This includes correct verb conjugations, adjectives, and pronouns where applicable. Always adapt second-person and first-person grammar, vocabulary, and tone to match the gender and personality of the character. If the language has no gendered forms (like English), maintain consistency in character tone and avoid gender assumptions unless instructed. Always narrate in second person (\'you\') as if speaking directly to the player-character."}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-08 19:35:33',
                'updated_at' => '2025-04-16 03:38:25',
            ),
        ));
        
        
    }
}