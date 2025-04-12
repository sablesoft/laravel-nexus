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
                'id' => 4,
                'user_id' => 1,
                'image_id' => 57,
                'portrait_id' => 56,
                'name' => '{"en":"Mara “Spark”","ru":"Мара “Искра”"}',
            'description' => '{"en":"Appearance: Short red hair, freckles, and a confident look. Wears a patched and studded leather jacket, torn jeans, and a neon wristband or shoelaces as accents. She walks with a light, confident stride.\\nPersonality: Energetic and witty, always ready with a sarcastic remark. Finds humor even in hopeless situations, and often lightens the mood with a grin or a joke.","ru":"Внешность: Короткая рыжая стрижка, веснушки, кожаная куртка с нашивками и клёпками. Джинсы с порезами, цветные элементы одежды (например, неоновый браслет или шнурки). Легкая походка и дерзкая поза.\\nХарактер: Энергичная, с живым умом и ироничным взглядом на мир. В каждой реплике — сарказм или легкая насмешка. Даже в пустоши умеет рассмешить."}',
                'is_public' => false,
                'created_at' => '2025-04-11 21:00:34',
                'updated_at' => '2025-04-12 00:36:29',
            ),
            1 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'image_id' => 58,
                'portrait_id' => 59,
                'name' => '{"en":"Tarek “Logic”","ru":"Тарек “Калькулятор”"}',
                'description' => '{"en":"Appearance: Bald, dark-skinned, wearing thin metal-rimmed glasses. Dressed in a dark blue windbreaker with a tactical backpack and antennas. An old wristwatch is visible on his wrist. Calm posture, deliberate movement.\\nPersonality: Cold-blooded rationalist. Speaks with precision and never wastes words. Sometimes comes off as boring, but usually turns out to be right. An analytical observer in every situation.","ru":"Внешность: Лысый, тёмная кожа, очки в тонкой металлической оправе, тёмная ветровка, тактический рюкзак с антеннами. Спокойная, ровная походка. На запястье старые наручные часы.\\nХарактер: Холодный ум, логик до мозга костей. Никаких эмоций — только расчёт и наблюдение. Говорит сухо и прямо. В любой ситуации — сначала анализ."}',
                'is_public' => false,
                'created_at' => '2025-04-11 21:01:23',
                'updated_at' => '2025-04-12 00:36:05',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'image_id' => 54,
                'portrait_id' => 55,
                'name' => '{"en":"Lia “Ashveil”","ru":"Лия “Пепельная”"}',
                'description' => '{"en":"Appearance: Pale and slender, with short dark hair. Wears a black turtleneck under a worn military jacket. An old ring hangs on a pendant around her neck. Her face is serious, with piercing eyes.\\nPersonality: Quiet and observant, with a tendency toward bleak thoughts. A pessimist with a sharp mind. Speaks briefly, almost in a whisper.","ru":"Внешность: Худощавая, бледная кожа, короткие тёмные волосы. Носит чёрную водолазку, поверх — потёртая армейская куртка. На шее висит амулет-кольцо. Её лицо строгое, взгляд пронизывающий.\\nХарактер: Тихая, наблюдательная, склонна к мрачным размышлениям. Пессимист, но с ясным умом. Говорит лаконично, почти шепотом."}',
                'is_public' => false,
                'created_at' => '2025-04-11 20:59:39',
                'updated_at' => '2025-04-12 00:36:51',
            ),
            3 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'image_id' => 61,
                'portrait_id' => 60,
                'name' => '{"en":"Nick “Ray”","ru":"Ник “Луч”"}',
                'description' => '{"en":"Appearance: Fair-skinned with long light brown hair tied back. Wears a gray shirt and a wool scarf. A small copper whistle hangs from his belt. His eyes are warm, his presence peaceful and grounded.\\nPersonality: An idealist and optimist by nature. Kind-hearted and sincere, sometimes naïve, but never cynical. Believes in people, in hope, in the good that still remains.","ru":"Внешность: Светлая кожа, длинные русые волосы, собранные назад. Серая рубашка, шерстяной шарф, на поясе — свисток. Теплый взгляд. Идёт уверенно, но без агрессии.\\nХарактер: Оптимист по призванию. Добрый, искренний, немного наивный. Верит в людей и надежду. Часто говорит просто, от души."}',
                'is_public' => false,
                'created_at' => '2025-04-11 21:02:28',
                'updated_at' => '2025-04-12 00:35:42',
            ),
        ));
        
        
    }
}