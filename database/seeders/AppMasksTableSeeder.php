<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppMasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.masks')->delete();
        
        \DB::table('app.masks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'image_id' => 7,
                'portrait_id' => 8,
                'name' => '{"en":"Nick Rayner","ru":"Ник Рейнер"}',
                'description' => '{"en":"Appearance:\\nFair-skinned with long light brown hair tied back in a loose knot. Wears a gray shirt, a wool scarf draped casually around his neck, and carries a small pendant at his belt with a faded pacifist symbol. His clothing is simple and travel-worn, touched by dust and sunlight. He walks openly through the world — no mask, no armor — his eyes warm and unguarded.\\nPersonality:\\nAn idealist by heart, Nick believes that the world, even broken, still holds good. Kind and sincere, sometimes overly trusting, but never bitter. He treats strangers with hope, not suspicion, and greets every new place like a possible beginning.","ru":"Внешность:\\nСветлая кожа, длинные русые волосы, собранные в небрежный узел. Серо-коричневая рубашка, шерстяной шарф свободно обвивает шею, на поясе — брелок со знаком пацифиста. Одежда простая, затёртая, в пыли и солнце. Он идёт открыто — без маски, без брони, с тёплым и чистым взглядом.\\nХарактер:\\nИдеалист по натуре, Ник верит, что даже разрушенный мир способен нести добро. Добрый, искренний, иногда излишне доверчивый, но не знает цинизма. Смотрит на людей с надеждой и встречает каждый новый путь как шанс начать заново."}',
                'gender' => 'male',
                'is_public' => false,
                'created_at' => '2025-04-11 21:02:28',
                'updated_at' => '2025-04-16 02:15:47',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'image_id' => 10,
                'portrait_id' => 11,
                'name' => '{"en":"Lia Novak","ru":"Лия Новак"}',
                'description' => '{"en":"Appearance:\\nPale and slender, with short dark hair and sharp gray eyes. Usually seen wearing a worn military jacket over a black turtleneck, along with thin protective gloves. In hazardous environments, she dons a transparent face mask with a built-in breathing filter, blending caution with subtle defiance. An old ring hangs on a pendant around her neck — a rare trace of sentimentality. Her expression is often unreadable, but always alert.\\nPersonality:\\nQuiet and intensely observant, Lia tends to keep her thoughts to herself. A pessimistic realist with a sharp, analytical mind. Her speech is brief, deliberate, and often edged with dry detachment. People rarely know what she\'s thinking — which suits her perfectly.","ru":"Внешность:\\nБледная, худощавая, с короткими тёмными волосами и пронизывающим серым взглядом. Обычно носит потёртую военную куртку поверх чёрной водолазки и тонкие защитные перчатки. При выходе наружу надевает прозрачную маску с дыхательным фильтром — осторожность, сочетающаяся с внутренним упрямством. На шее — старое кольцо на цепочке, единственная сентиментальная деталь. Лицо спокойное, но внимательное.\\nХарактер:\\nМолчаливая и крайне наблюдательная. Склонна к мрачному взгляду на вещи, но ум её острый и хладнокровный. Говорит коротко, точно, с оттенком сухой отстранённости. Мало кто догадывается, что она на самом деле чувствует — и её это устраивает."}',
                'gender' => 'female',
                'is_public' => false,
                'created_at' => '2025-04-11 20:59:39',
                'updated_at' => '2025-04-16 02:09:12',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'image_id' => 12,
                'portrait_id' => 4,
                'name' => '{"en":"Tarek Basim","ru":"Тарек Басим"}',
                'description' => '{"en":"Appearance:\\nBald and dark-skinned, with metal-rimmed glasses and a steady, focused gaze. Typically wears a dark blue windbreaker with black tactical gloves, and carries a utility backpack equipped with antennas and monitoring gear. In contaminated zones, he wears a full protective suit with a sealed face visor and breathing system. A worn wristwatch is always visible — meticulously maintained. Every movement is intentional, controlled.\\nPersonality:\\nRational to a fault, Tarek approaches life like a system to be mapped and understood. Rarely emotional, always calculating. He speaks clearly and efficiently, often bypassing small talk. Others may find him cold, but when precision is needed, there’s no one better to have around.","ru":"Внешность:\\nЛысый, тёмная кожа, очки в тонкой металлической оправе, спокойный и сосредоточенный взгляд. Обычно носит тёмно-синюю ветровку и чёрные тактические перчатки, а за спиной — утилитарный рюкзак с антеннами и приборами. При выходе в заражённые зоны надевает полноценный защитный костюм с герметичным визором и дыхательной системой. На запястье — поношенные, но ухоженные часы. Каждое его движение точное и выверенное.\\nХарактер:\\nДо предела рационален, воспринимает мир как систему, которую нужно понять. Практически не проявляет эмоций, всегда расчётлив. Говорит чётко и по делу, избегает пустых разговоров. Может показаться холодным, но в ситуации, где нужна точность — лучший союзник."}',
                'gender' => 'male',
                'is_public' => false,
                'created_at' => '2025-04-11 21:01:23',
                'updated_at' => '2025-04-16 02:08:07',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 3,
                'image_id' => 6,
                'portrait_id' => 14,
                'name' => '{"en":"Mara Kessler","ru":"Мара Кесслер"}',
                'description' => '{"en":"Appearance:\\nShort red hair, freckles, and a confident, challenging gaze. She wears a patched and studded leather jacket, torn jeans, and mismatched neon accents — a wristband here, a shoelace there. Her look is bold and unfiltered, just like her attitude. No mask, no filters — just skin, wind, and sarcasm.\\nPersonality:\\nSharp-witted and always on the move, Mara meets the world with sarcasm, speed, and a grin. She jokes when others would shut down. For her, laughter is a weapon and independence is survival. Rules bore her. Caution is optional.","ru":"Внешность:\\nКороткие рыжие волосы, веснушки и уверенный, дерзкий взгляд. Потёртая кожаная куртка с заклёпками, рваные джинсы, неоновые акценты — то браслет, то шнурки. Внешний вид вызывающий и честный, как и она сама. Без масок, без фильтров — только кожа, ветер и ирония.\\nХарактер:\\nОстрая на язык и всегда в движении, Мара встречает мир с усмешкой и скоростью. Там, где другие молчат, она шутит. Для неё смех — это оружие, а свобода — единственная защита. Правила её раздражают. Осторожность — не всегда обязательна."}',
                'gender' => 'female',
                'is_public' => false,
                'created_at' => '2025-04-11 21:00:34',
                'updated_at' => '2025-04-16 02:12:42',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 3,
                'image_id' => 5,
                'portrait_id' => NULL,
                'name' => '{"en":"Girl"}',
                'description' => '{"en":null}',
                'gender' => 'female',
                'is_public' => false,
                'created_at' => '2025-04-24 19:00:11',
                'updated_at' => '2025-04-24 19:00:11',
            ),
        ));
        
        
    }
}