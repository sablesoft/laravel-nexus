<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.images')->delete();
        
        \DB::table('app.images')->insert(array (
            0 => 
            array (
                'id' => 62,
                'user_id' => 1,
                'title' => 'Screen - Recorder',
                'prompt' => 'A close-up portrait-oriented image of a small, handheld portable voice recorder lying on a dusty car hood in a post-apocalyptic setting. The recorder is compact and worn, with scuffed plastic casing, faded buttons, and a small label marked “REC.” It looks like a personal device used for voice memos. Surrounding it are faint traces of dust, dried leaves, and rust. In the softly blurred background, a broken windshield and overgrown forest are visible. Light falls dramatically on the recorder, highlighting its texture and loneliness — as if it’s the last witness to a lost world. Cinematic atmosphere, soft contrast, realistic details, no people.',
                'has_glitches' => false,
                'attempts' => 2,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-UTSY50UcQG3siM0XN0Dv9JGk.png',
                'path_md' => 'images_md/img-UTSY50UcQG3siM0XN0Dv9JGk.webp',
                'path_sm' => 'images_sm/img-UTSY50UcQG3siM0XN0Dv9JGk.webp',
                'is_public' => false,
                'created_at' => '2025-04-14 20:44:11',
                'updated_at' => '2025-04-14 20:52:03',
            ),
            1 => 
            array (
                'id' => 51,
                'user_id' => 1,
                'title' => 'Cover - After People',
            'prompt' => 'A cinematic, wide-angle landscape of a world after human extinction. A once-bustling city now overgrown with nature: crumbling buildings wrapped in vines, trees sprouting from rooftops, rusted vehicles half-buried in tall grass. A broken billboard in the distance, faded and unreadable. Animals wander freely — a deer stands near an abandoned bus, birds fly over shattered windows. The sky is overcast with scattered sunbeams breaking through. The mood is quiet, melancholic, and awe-inspiring. No people. Horizontal (landscape) format, realistic and atmospheric style, inspired by Life After People.',
                'has_glitches' => false,
                'attempts' => 2,
                'aspect' => 'landscape',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-tlRu8A3DoZmaHHcmXOVvg0MV.png',
                'path_md' => 'images_md/img-tlRu8A3DoZmaHHcmXOVvg0MV.webp',
                'path_sm' => 'images_sm/img-tlRu8A3DoZmaHHcmXOVvg0MV.webp',
                'is_public' => false,
                'created_at' => '2025-04-08 18:16:50',
                'updated_at' => '2025-04-15 15:39:19',
            ),
            2 => 
            array (
                'id' => 52,
                'user_id' => 1,
                'title' => 'Screen - Prologue',
                'prompt' => 'A scenic post-apocalyptic forest road. A narrow dirt road winds through a lush, overgrown forest filled with tall grass, moss-covered stones, and thick trees. The sky is softly overcast, casting diffused daylight across the greenery. Birds are flying between branches, and a small fox is running across the road in the distance. Nature has fully reclaimed the area — wildflowers bloom, vines hang from trees, and roots crack the edges of the broken road.

Half-buried rusted road signs and metal debris are partially hidden in the undergrowth, hinting at the past. The scene feels quiet, alive, and vibrant — not desolate, but wild and untamed. No people or vehicles. Realistic, cinematic detail. Horizontal landscape format.',
                'has_glitches' => false,
                'attempts' => 2,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-sVZLe5vIaUSBuzJGc9cperfX.png',
                'path_md' => 'images_md/img-sVZLe5vIaUSBuzJGc9cperfX.webp',
                'path_sm' => 'images_sm/img-sVZLe5vIaUSBuzJGc9cperfX.webp',
                'is_public' => false,
                'created_at' => '2025-04-08 19:41:40',
                'updated_at' => '2025-04-15 16:28:03',
            ),
            3 => 
            array (
                'id' => 59,
                'user_id' => 1,
                'title' => 'Portrait - Tarek',
                'prompt' => 'A full-body portrait of a man in a high-tech post-apocalyptic hazmat suit with a full-face visor, integrated respirator, and tactical detailing. The suit is dark blue-gray, weathered but functional, with gloves, boots, and a reinforced backpack with antennas. He stands on a cracked and overgrown road in a ruined forest zone, surrounded by remnants of old machines and cables. His pose is steady, composed, and alert. Cinematic lighting, realistic atmosphere, light mist in the background. No text, UI, or extra elements. Centered composition with visible space above the head and below the boots.',
                'has_glitches' => false,
                'attempts' => 5,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-EkrV7v02Frz92Rgeu98ubQ8f.png',
                'path_md' => 'images_md/img-EkrV7v02Frz92Rgeu98ubQ8f.webp',
                'path_sm' => 'images_sm/img-EkrV7v02Frz92Rgeu98ubQ8f.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:54:50',
                'updated_at' => '2025-04-16 01:56:30',
            ),
            4 => 
            array (
                'id' => 22,
                'user_id' => 1,
                'title' => 'Post-Apocalyptic Scavenger',
                'prompt' => 'A rugged survivor in a post-apocalyptic wasteland, wearing a tattered hood and gas mask. Their armor is made from scavenged metal plates, and they clutch a makeshift energy rifle. Dust and smoke fill the air, with ruined skyscrapers in the background.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-JEjAq6c10uPtjjQYNAv1Iqvi.png',
                'path_md' => 'images_md/img-JEjAq6c10uPtjjQYNAv1Iqvi.webp',
                'path_sm' => 'images_sm/img-JEjAq6c10uPtjjQYNAv1Iqvi.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:04:40',
                'updated_at' => '2025-03-23 04:33:47',
            ),
            5 => 
            array (
                'id' => 57,
                'user_id' => 1,
                'title' => 'Ava - Mara',
                'prompt' => 'upper body portrait of a woman with short red hair, freckles, wearing a patched leather jacket and a neon wristband, playful smirk, bright eyes, centered in frame with space above her head, dusty graffiti-style background, high contrast, post-apocalyptic vibe',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-uOio5FrAxGONw1Us0Pgynmtt.png',
                'path_md' => 'images_md/img-uOio5FrAxGONw1Us0Pgynmtt.webp',
                'path_sm' => 'images_sm/img-uOio5FrAxGONw1Us0Pgynmtt.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:51:44',
                'updated_at' => '2025-04-11 20:51:48',
            ),
            6 => 
            array (
                'id' => 61,
                'user_id' => 1,
                'title' => 'Ava - Nick',
                'prompt' => 'upper body portrait of a man with long light brown hair tied back, fair skin, warm gentle smile, wearing a gray shirt and a wool scarf, copper whistle strap slightly visible on his chest, centered with space above the head, soft lighting, faded hopeful background, emotional atmosphere',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-LYdrx1Scq8vFVC19f6IxpCkG.png',
                'path_md' => 'images_md/img-LYdrx1Scq8vFVC19f6IxpCkG.webp',
                'path_sm' => 'images_sm/img-LYdrx1Scq8vFVC19f6IxpCkG.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:56:13',
                'updated_at' => '2025-04-11 20:56:13',
            ),
            7 => 
            array (
                'id' => 60,
                'user_id' => 1,
                'title' => 'Portrait - Nick',
                'prompt' => 'a gentle man with long light brown hair tied back, fair skin, wearing a gray shirt, wool scarf, cargo pants, and visible leather boots, with a warm calm smile, a small copper whistle hanging from his belt, walking toward the viewer on a misty post-apocalyptic road with scattered greenery and broken structures, cinematic photo, realistic lighting, full-body centered composition, only one person, no duplicates, no interface elements, visible space above head and below boots',
                'has_glitches' => false,
                'attempts' => 2,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-lCplIEMpXkOhcoQCdX9M7jkX.png',
                'path_md' => 'images_md/img-lCplIEMpXkOhcoQCdX9M7jkX.webp',
                'path_sm' => 'images_sm/img-lCplIEMpXkOhcoQCdX9M7jkX.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:55:55',
                'updated_at' => '2025-04-11 20:57:07',
            ),
            8 => 
            array (
                'id' => 53,
                'user_id' => 1,
                'title' => 'Screen - Porch',
                'prompt' => 'A weathered wooden cabin porch in a quiet forest. The entrance features a heavy, surprisingly sturdy front door. A doormat lies before it, covered in dry leaves — any writing on it obscured. The porch boards are aged and slightly warped, surrounded by overgrown vegetation. The mood is still and tense, with muted earthy tones and soft, overcast light filtering through the trees.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-rwzfcWmxH8JSWHA2q1mYerP1.png',
                'path_md' => 'images_md/img-rwzfcWmxH8JSWHA2q1mYerP1.webp',
                'path_sm' => 'images_sm/img-rwzfcWmxH8JSWHA2q1mYerP1.webp',
                'is_public' => false,
                'created_at' => '2025-04-08 19:48:41',
                'updated_at' => '2025-04-08 19:52:54',
            ),
            9 => 
            array (
                'id' => 54,
                'user_id' => 1,
                'title' => 'Ava - Lia',
                'prompt' => 'Upper body portrait of a pale, slender woman with short dark hair and gray eyes, wearing a black turtleneck and a worn military jacket. An old ring pendant hangs from her neck. She sits calmly in a dimly lit underground bunker room with metal walls and soft yellow lights, surrounded by scattered tech devices and survival gear. Her expression is thoughtful and focused. Cinematic lighting, neutral tones, realistic style, post-apocalyptic atmosphere. No helmet or mask. Centered composition with visible space above the head.
',
                'has_glitches' => false,
                'attempts' => 6,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-nvrr3rCCafMgMw30z92x7Iok.png',
                'path_md' => 'images_md/img-nvrr3rCCafMgMw30z92x7Iok.webp',
                'path_sm' => 'images_sm/img-nvrr3rCCafMgMw30z92x7Iok.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 19:25:50',
                'updated_at' => '2025-04-16 01:53:28',
            ),
            10 => 
            array (
                'id' => 55,
                'user_id' => 1,
                'title' => 'Portrait - Lia',
                'prompt' => 'A full-body portrait of a woman in a full-body post-apocalyptic hazmat suit with a clear face shield and built-in respirator. The suit is dark gray with tactical detailing, gloves, and boots, designed for biohazard protection. A worn utility backpack is visible. She walks alone through an overgrown, ruined city street, surrounded by collapsed buildings and wild vegetation. Her body language is alert and focused. Cinematic, realistic lighting, fog in the background, muted color palette. No extra people, text, or interface elements. Centered composition with space above the head and below the boots.',
                'has_glitches' => false,
                'attempts' => 24,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-sPp9svlGd1tDKnr9iK263LeS.png',
                'path_md' => 'images_md/img-sPp9svlGd1tDKnr9iK263LeS.webp',
                'path_sm' => 'images_sm/img-sPp9svlGd1tDKnr9iK263LeS.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 19:26:24',
                'updated_at' => '2025-04-16 01:54:00',
            ),
            11 => 
            array (
                'id' => 58,
                'user_id' => 1,
                'title' => 'Ava - Tarek',
                'prompt' => 'Upper body portrait of a bald man with dark skin and metal-rimmed glasses, wearing a dark blue windbreaker. He sits inside a dimly lit underground tech bunker with worn metal walls, old equipment, and cables running along the background. A small wristwatch is visible. His expression is calm, thoughtful, and analytical. He appears comfortable, focused, and deep in thought. Cinematic lighting, realistic detail, neutral post-apocalyptic color palette. No helmet or mask. Centered composition with visible space above the head.',
                'has_glitches' => false,
                'attempts' => 3,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-pXiSDKNoJtpCHb10sz6BHBnu.png',
                'path_md' => 'images_md/img-pXiSDKNoJtpCHb10sz6BHBnu.webp',
                'path_sm' => 'images_sm/img-pXiSDKNoJtpCHb10sz6BHBnu.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:54:13',
                'updated_at' => '2025-04-16 01:55:45',
            ),
            12 => 
            array (
                'id' => 33,
                'user_id' => 1,
                'title' => 'Seaside Shore Screen',
            'prompt' => 'A scenic view of a peaceful sandy beach with gentle waves touching the shore. Scattered seashells, driftwood, and small crabs add detail. The sky is painted in warm hues of a sunset, making the scene feel tranquil and inviting. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-ogTN2wRpCjSiGzSRl5PqBcSt.png',
                'path_md' => 'images_md/img-ogTN2wRpCjSiGzSRl5PqBcSt.webp',
                'path_sm' => 'images_sm/img-ogTN2wRpCjSiGzSRl5PqBcSt.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:57:05',
                'updated_at' => '2025-03-23 04:25:46',
            ),
            13 => 
            array (
                'id' => 56,
                'user_id' => 1,
                'title' => 'Portrait - Mara',
                'prompt' => 'a freckled woman with short red hair, wearing a patched and studded leather jacket, torn dark jeans, a neon wristband, and visible lace-up boots, with a playful expression, walking toward the viewer down a dusty post-apocalyptic alley filled with graffiti and debris, cinematic photo, realistic lighting, full-body centered composition, only one person, no duplicates, no interface elements, visible space above head and below boots',
                'has_glitches' => false,
                'attempts' => 2,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-xEZE0I6UA41UbbSzs1OeUZJV.png',
                'path_md' => 'images_md/img-xEZE0I6UA41UbbSzs1OeUZJV.webp',
                'path_sm' => 'images_sm/img-xEZE0I6UA41UbbSzs1OeUZJV.webp',
                'is_public' => false,
                'created_at' => '2025-04-11 20:51:28',
                'updated_at' => '2025-04-11 20:52:55',
            ),
        ));
        
        
    }
}