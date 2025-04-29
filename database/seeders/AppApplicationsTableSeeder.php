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
                'user_id' => 3,
                'image_id' => 2,
                'title' => '{"en":"After People","ru":"После Людей"}',
                'description' => '{"en":"Humanity is gone — or nearly so. An unknown and unbeatable virus, called the Doomsday Virus, spared flora and fauna, but wiped out nearly all humans. Among the rare survivors, two small groups emerged: the Walkers — natural immunes who roam freely through the ruins of civilization with uncovered faces, and the Shells — those who hide behind a shield of technology, clinging to the past and trying to reclaim it.\\n\\nThis story unfolds in the silence left behind. In forests where trees have reclaimed the land, and in cities swallowed by green, you will be one of the last. Or the first? One way or another, life goes on. In the years of collapse, the past has grown wild with rumors and legends. Can the truth still be found? And does it even matter?\\n\\nYour choices, discoveries, and fears will shape not only your path — but whether you remain human. Perhaps even the fate of the world rests in your hands. Many events are dynamically generated, shaped by your character, your past, and the world\'s stubborn memory.\\n\\nWhat you find among the ruins will change you. Or break you.","ru":"Человечество исчезло — или почти. Неизвестный и непобедимый вирус, названный Вирусом Судного Дня, обошёл стороной флору и фауну, но истребил людей. Среди редких выживших сформировались две малочисленные группы: Странники — естественные иммуны, свободно странствующие по руинам былой цивилизации с открытым лицом, и Панцири — те, кто прячутся от враждебной для них среды за щитом технологий и пытаются вернуть былые времена.\\n\\nЭта история разворачивается в тишине, оставшейся после. В лесах, где деревья отвоевали землю, и в городах, поглощённых зеленью, ты будешь одним из последних. Или первых? Ведь так или иначе, жизнь продолжается. За время разрухи прошлое обросло множеством слухов и легенд. Удастся ли теперь отыскать правду? Да и нужно ли это?\\n\\nТвои выборы, находки и страхи определят не только маршрут — но и то, останешься ли ты человеком. А может оказаться, что и судьба всего этого мира в твоих руках. Многие события генерируется динамически, в зависимости от твоего персонажа, прошлого и упрямой памяти этого мира.\\n\\nТо, что ты найдёшь среди руин, изменит тебя. Или сломает."}',
                'is_public' => true,
                'seats' => 1,
                'masks_allowed' => false,
                'states' => '{"has": {"time": {"type": "enum", "value": "Dawn", "options": ["Dawn", "Morning", "Late-Morning", "Noon", "Afternoon", "Sunset", "Evening", "Night", "Midnight", "Late-Night", "Pre-Dawn"]}, "weather": {"type": "enum", "value": "Clear", "options": ["Clear", "Warm-Breeze", "Hazy", "Cloudy", "Overcast", "Light-Rain", "Heavy-Rain", "Storm", "Fog", "Humid", "Cold-Drizzle", "Frost", "Snow", "Blizzard"]}}}',
                'character_states' => '{"has": {"place": {"type": "enum", "value": "Road", "options": ["Road", "Porch", "Room", "Backyard"]}}}',
                'behaviors' => '{"can": {"hit": {"description": "Striking a target or surface with force."}, "look": {"description": "Observing objects, areas, or directions visually without physical contact."}, "move": {"description": "Moving toward a destination or through a location."}, "open": {"description": "Opening an object to change its state from closed to open."}, "take": {"description": "Taking an object from one place and transferring it elsewhere."}, "listen": {"description": "Perceiving sounds from a source or direction."}, "search": {"description": "Physically inspecting objects or areas to uncover hidden items."}}}',
            'init' => '[{"comment":">>Prepare weather and time"},{"chat.state":{"weather":"chat.randomState(\'weather\')","time":"chat.randomState(\'time\')"}}]',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 19:35:33',
                'updated_at' => '2025-04-28 06:33:15',
            ),
        ));
        
        
    }
}