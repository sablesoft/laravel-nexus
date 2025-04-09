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
                'id' => 51,
                'user_id' => 1,
                'title' => 'Cover - In The Dusk',
                'prompt' => 'A dirt road runs through a dense forest. In the upper left corner, taking up much of the space, stands an old cabin, partially hidden by trees and mist. Near it, roughly in the center of the image, is a worn but sturdy sedan parked beside the road. The sky is covered with a dusty grey tone. The overall color palette is reddish and earthy. The composition draws the viewer’s eye from the car in the foreground to the looming cabin in the background, evoking a sense of unease but also a faint hope. Cinematic, slightly grim, and atmospheric. Landscape format.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'landscape',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-UcFE0qLYFoIE7f76Gpp7CaAG.png',
                'path_md' => 'images_md/img-UcFE0qLYFoIE7f76Gpp7CaAG.webp',
                'path_sm' => 'images_sm/img-UcFE0qLYFoIE7f76Gpp7CaAG.webp',
                'is_public' => false,
                'created_at' => '2025-04-08 18:16:50',
                'updated_at' => '2025-04-08 19:28:22',
            ),
            1 => 
            array (
                'id' => 52,
                'user_id' => 1,
                'title' => 'Screen - Prologue',
                'prompt' => 'A dirt road runs through a dense forest. The sky is covered with a dusty grey tone, casting a muted light over the landscape. The overall color palette is reddish and earthy — faded rust, dried clay, and muted browns dominate the scene. The road winds into the distance, drawing the eye along its curve as it disappears into the trees, suggesting both journey and uncertainty. The foliage is overgrown and tangled, encroaching on the road like nature reclaiming what’s left behind. A few broken road signs and remnants of a forgotten world lie half-buried near the edges. The atmosphere is cinematic, slightly grim, and heavy with silence — the kind that feels loud. Dust floats in the air.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-u77KT9O9YppePJY5n7Q8hu0t.png',
                'path_md' => 'images_md/img-u77KT9O9YppePJY5n7Q8hu0t.webp',
                'path_sm' => 'images_sm/img-u77KT9O9YppePJY5n7Q8hu0t.webp',
                'is_public' => false,
                'created_at' => '2025-04-08 19:41:40',
                'updated_at' => '2025-04-08 19:41:42',
            ),
            2 => 
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
            3 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'title' => 'Discussion',
                'prompt' => 'A team of fantasy adventurers stand in front of a massive stone door in a cliff, discussing how to open it.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'landscape',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-jDvB1lAa8HbQZ256rPSXxoGm.png',
                'path_md' => 'images_md/img-jDvB1lAa8HbQZ256rPSXxoGm.webp',
                'path_sm' => 'images_sm/img-jDvB1lAa8HbQZ256rPSXxoGm.webp',
                'is_public' => true,
                'created_at' => '2025-03-08 03:34:51',
                'updated_at' => '2025-03-23 04:37:19',
            ),
            4 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => 'Crash',
                'prompt' => 'An Imperial Star Wars cruiser crashed in the middle of an endless alien desert',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'landscape',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-wFoEGgzbmCGfnawfZHj1VkDu.png',
                'path_md' => 'images_md/img-wFoEGgzbmCGfnawfZHj1VkDu.webp',
                'path_sm' => 'images_sm/img-wFoEGgzbmCGfnawfZHj1VkDu.webp',
                'is_public' => true,
                'created_at' => '2025-03-07 05:46:49',
                'updated_at' => '2025-03-23 04:38:53',
            ),
            5 => 
            array (
                'id' => 26,
                'user_id' => 1,
                'title' => 'Norse Battle Goddess',
                'prompt' => 'A fierce Norse warrior goddess with intricate braids in her fiery red hair, wearing golden armor and a wolf-fur cloak. She holds a glowing runic axe, and a storm rages behind her as she stands on a Viking longship.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-08aGJkdoL1k0KNUzfdzuuB6L.png',
                'path_md' => 'images_md/img-08aGJkdoL1k0KNUzfdzuuB6L.webp',
                'path_sm' => 'images_sm/img-08aGJkdoL1k0KNUzfdzuuB6L.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:06:11',
                'updated_at' => '2025-03-23 05:09:46',
            ),
            6 => 
            array (
                'id' => 34,
                'user_id' => 1,
                'title' => 'Jungle Trail Screen',
            'prompt' => 'A dense jungle pathway covered in mist, surrounded by towering ancient trees, thick vines, and exotic flowers. Sunlight filters through the dense canopy, casting a golden glow over the moss-covered stones and leaves. The path looks like it leads to something mysterious ahead. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-ZuLPxMgXut32bhV4FkU0yAts.png',
                'path_md' => 'images_md/img-ZuLPxMgXut32bhV4FkU0yAts.webp',
                'path_sm' => 'images_sm/img-ZuLPxMgXut32bhV4FkU0yAts.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:57:25',
                'updated_at' => '2025-03-23 05:17:46',
            ),
            7 => 
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
            8 => 
            array (
                'id' => 31,
                'user_id' => 1,
                'title' => 'Explorer’s Journal Screen',
            'prompt' => 'An open adventurer’s journal on a rustic wooden desk, surrounded by ink bottles, quills, wax seals, and scattered old maps. The pages contain elegant handwritten notes, sketches of creatures, and cryptic symbols. A warm glow from a candle illuminates the scene, adding a vintage explorer’s touch. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-IX0k0DVIigBSbMzedmxKfOrV.png',
                'path_md' => 'images_md/img-IX0k0DVIigBSbMzedmxKfOrV.webp',
                'path_sm' => 'images_sm/img-IX0k0DVIigBSbMzedmxKfOrV.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:51:22',
                'updated_at' => '2025-03-23 04:32:10',
            ),
            9 => 
            array (
                'id' => 30,
                'user_id' => 1,
                'title' => 'Adventurer’s Inventory Screen',
            'prompt' => 'A detailed and atmospheric adventurer\'s inventory laid out on a wooden table. Includes a worn leather backpack, rolled-up maps, a compass, a dagger, potions in glass vials, gold coins, and an old lantern. The setting is dimly lit by candlelight, creating a sense of mystery and adventure. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-YIEDpwg9xGthqNEQRaGpk0TW.png',
                'path_md' => 'images_md/img-YIEDpwg9xGthqNEQRaGpk0TW.webp',
                'path_sm' => 'images_sm/img-YIEDpwg9xGthqNEQRaGpk0TW.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:48:57',
                'updated_at' => '2025-03-23 04:32:26',
            ),
            10 => 
            array (
                'id' => 28,
                'user_id' => 1,
                'title' => 'Gothic Phantom Empress',
                'prompt' => 'A mysterious gothic empress in a dark, enchanted castle, wearing an elegant black silk dress with silver embroidery. Her piercing silver eyes glow faintly, and a spectral aura surrounds her. She stands near a grand candlelit throne, with ravens perched on twisted iron chandeliers above.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-F3eS2yLINNjK8apl5sgchRWD.png',
                'path_md' => 'images_md/img-F3eS2yLINNjK8apl5sgchRWD.webp',
                'path_sm' => 'images_sm/img-F3eS2yLINNjK8apl5sgchRWD.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:08:46',
                'updated_at' => '2025-03-23 04:32:51',
            ),
            11 => 
            array (
                'id' => 27,
                'user_id' => 1,
                'title' => 'Digital Dream Shaman',
                'prompt' => 'A futuristic shaman who exists between the digital and spiritual worlds, wearing a robe infused with glowing circuit patterns. His cybernetic face mask displays shifting ancient symbols, and holographic spirits swirl around him in a neon-lit temple.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-9r83OpXCEmKrZTVOJKGOWle2.png',
                'path_md' => 'images_md/img-9r83OpXCEmKrZTVOJKGOWle2.webp',
                'path_sm' => 'images_sm/img-9r83OpXCEmKrZTVOJKGOWle2.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:06:46',
                'updated_at' => '2025-03-23 04:33:03',
            ),
            12 => 
            array (
                'id' => 25,
                'user_id' => 1,
                'title' => 'Retro-Futuristic Space Pilot',
                'prompt' => 'A retro-futuristic space pilot from the 1950s sci-fi era, wearing a sleek metallic spacesuit with a glass dome helmet. He has a confident smirk, a laser pistol holstered at his side, and a gleaming chrome spaceship behind him, set against the backdrop of a ringed planet.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-d36K1u4lpXjemdsYdlA2AV5u.png',
                'path_md' => 'images_md/img-d36K1u4lpXjemdsYdlA2AV5u.webp',
                'path_sm' => 'images_sm/img-d36K1u4lpXjemdsYdlA2AV5u.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:05:49',
                'updated_at' => '2025-03-23 04:33:16',
            ),
            13 => 
            array (
                'id' => 23,
                'user_id' => 1,
                'title' => 'Ancient Sorcerer',
                'prompt' => 'A wise and mysterious sorcerer with a long silver beard, deep violet robes covered in arcane runes, and piercing glowing eyes. He holds an ancient spellbook, and swirling magical energy crackles around his fingertips.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-2A1a2T6qzgy4tKurT93PgS9x.png',
                'path_md' => 'images_md/img-2A1a2T6qzgy4tKurT93PgS9x.webp',
                'path_sm' => 'images_sm/img-2A1a2T6qzgy4tKurT93PgS9x.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:05:02',
                'updated_at' => '2025-03-23 04:33:34',
            ),
            14 => 
            array (
                'id' => 21,
                'user_id' => 1,
                'title' => 'Celestial Warrior',
                'prompt' => 'A celestial warrior with golden wings, clad in radiant silver armor, holding a divine flaming sword. Her eyes glow with cosmic energy, and behind her, the vast expanse of a nebula-filled galaxy stretches infinitely.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-PpWnX1z0tpKy9pLF27QvEwBQ.png',
                'path_md' => 'images_md/img-PpWnX1z0tpKy9pLF27QvEwBQ.webp',
                'path_sm' => 'images_sm/img-PpWnX1z0tpKy9pLF27QvEwBQ.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:04:07',
                'updated_at' => '2025-03-23 04:34:05',
            ),
            15 => 
            array (
                'id' => 20,
                'user_id' => 1,
                'title' => 'Steampunk Explorer',
                'prompt' => 'A steampunk adventurer with brass goggles, a mechanical arm, and a leather trench coat covered in clockwork gears. His airship floats in the background, and he holds a glowing map with mysterious symbols, ready for his next grand expedition.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-RLs3MFMSaO20EXf8F4YbhYlg.png',
                'path_md' => 'images_md/img-RLs3MFMSaO20EXf8F4YbhYlg.webp',
                'path_sm' => 'images_sm/img-RLs3MFMSaO20EXf8F4YbhYlg.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:02:13',
                'updated_at' => '2025-03-23 04:34:19',
            ),
            16 => 
            array (
                'id' => 19,
                'user_id' => 1,
                'title' => 'Cyberpunk Samurai',
                'prompt' => 'A cyberpunk samurai with glowing neon tattoos, wearing a futuristic armored kimono, standing in the rain with a holographic katana. The neon city lights reflect in their cybernetic eyes, blending traditional Japanese aesthetics with high-tech sci-fi elements.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-SI9gDRwxwg70QerwyqNgsXE1.png',
                'path_md' => 'images_md/img-SI9gDRwxwg70QerwyqNgsXE1.webp',
                'path_sm' => 'images_sm/img-SI9gDRwxwg70QerwyqNgsXE1.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:00:33',
                'updated_at' => '2025-03-23 04:34:31',
            ),
            17 => 
            array (
                'id' => 18,
                'user_id' => 1,
                'title' => 'Alien - 1',
                'prompt' => 'Close-up portrait of an alien hero in the style of Star Wars',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-bXS4C0D2rpWtdG9O6WZRpJz1.png',
                'path_md' => 'images_md/img-bXS4C0D2rpWtdG9O6WZRpJz1.webp',
                'path_sm' => 'images_sm/img-bXS4C0D2rpWtdG9O6WZRpJz1.webp',
                'is_public' => false,
                'created_at' => '2025-03-12 05:02:09',
                'updated_at' => '2025-03-23 04:34:44',
            ),
            18 => 
            array (
                'id' => 17,
                'user_id' => 1,
                'title' => 'Man - 1',
                'prompt' => 'Close-up portrait of a man in diesel punk style',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-IOyPYkqZeSYkiI3tlm1fx85T.png',
                'path_md' => 'images_md/img-IOyPYkqZeSYkiI3tlm1fx85T.webp',
                'path_sm' => 'images_sm/img-IOyPYkqZeSYkiI3tlm1fx85T.webp',
                'is_public' => false,
                'created_at' => '2025-03-12 04:59:55',
                'updated_at' => '2025-03-23 04:34:56',
            ),
            19 => 
            array (
                'id' => 16,
                'user_id' => 1,
                'title' => 'Woman - 1',
                'prompt' => 'Portrait of a strong-willed young woman in fantasy style',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-Cc0MqStl3k7tpK8KXxPmn4JK.png',
                'path_md' => 'images_md/img-Cc0MqStl3k7tpK8KXxPmn4JK.webp',
                'path_sm' => 'images_sm/img-Cc0MqStl3k7tpK8KXxPmn4JK.webp',
                'is_public' => false,
                'created_at' => '2025-03-12 04:58:19',
                'updated_at' => '2025-03-23 04:35:21',
            ),
            20 => 
            array (
                'id' => 15,
                'user_id' => 1,
                'title' => 'Masters',
                'prompt' => 'Epic fantasy heroes play thoughtful chess at a large chessboard',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-RF1LWsK3uXn0tmxr9Z9xVYhN.png',
                'path_md' => 'images_md/img-RF1LWsK3uXn0tmxr9Z9xVYhN.webp',
                'path_sm' => 'images_sm/img-RF1LWsK3uXn0tmxr9Z9xVYhN.webp',
                'is_public' => false,
                'created_at' => '2025-03-08 03:46:07',
                'updated_at' => '2025-03-23 04:35:32',
            ),
            21 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'title' => 'Knife',
                'prompt' => 'Mayan obsidian knife close up',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-jUzXIBmOJODsOV1lxEG1mFAZ.png',
                'path_md' => 'images_md/img-jUzXIBmOJODsOV1lxEG1mFAZ.webp',
                'path_sm' => 'images_sm/img-jUzXIBmOJODsOV1lxEG1mFAZ.webp',
                'is_public' => false,
                'created_at' => '2025-03-08 02:26:26',
                'updated_at' => '2025-03-23 04:38:20',
            ),
            22 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'title' => 'Sleepy dog',
                'prompt' => 'Sleepy dog',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-t8mBQoWIFcYfCGBzWPCmWsGe.png',
                'path_md' => 'images_md/img-t8mBQoWIFcYfCGBzWPCmWsGe.webp',
                'path_sm' => 'images_sm/img-t8mBQoWIFcYfCGBzWPCmWsGe.webp',
                'is_public' => false,
                'created_at' => '2025-03-07 05:14:48',
                'updated_at' => '2025-03-23 04:39:44',
            ),
            23 => 
            array (
                'id' => 24,
                'user_id' => 1,
                'title' => 'Mythical Forest Guardian',
                'prompt' => 'A mystical humanoid creature covered in moss and vines, with antlers made of twisting tree branches. Her glowing green eyes shimmer like emeralds, and fireflies float around her as she stands deep in an enchanted forest.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'square',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-y49h0VyOBMTX8rez3g2Z9fvJ.png',
                'path_md' => 'images_md/img-y49h0VyOBMTX8rez3g2Z9fvJ.webp',
                'path_sm' => 'images_sm/img-y49h0VyOBMTX8rez3g2Z9fvJ.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 17:05:28',
                'updated_at' => '2025-03-23 05:10:14',
            ),
            24 => 
            array (
                'id' => 44,
                'user_id' => 1,
                'title' => 'Point of View',
                'prompt' => 'A group of four fantasy adventurers stands at the edge of a cliff, gazing into the distance at a vast, fertile valley with a majestic castle on the horizon. One of them is holding a spyglass, carefully observing the distant lands. The party consists of classic RPG characters, including a warrior, a bard, a mage, and a druid, representing typical fantasy races such as humans, elves, and dwarves. The scene is set in a rich fantasy world, with dramatic lighting and breathtaking scenery.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'landscape',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-aOdgaSjM0gmnj5zfLpnc2UOw.png',
                'path_md' => 'images_md/img-aOdgaSjM0gmnj5zfLpnc2UOw.webp',
                'path_sm' => 'images_sm/img-aOdgaSjM0gmnj5zfLpnc2UOw.webp',
                'is_public' => false,
                'created_at' => '2025-03-19 22:29:03',
                'updated_at' => '2025-03-23 04:13:00',
            ),
            25 => 
            array (
                'id' => 39,
                'user_id' => 1,
                'title' => 'Mountain Peak Camp Screen',
            'prompt' => 'A high-altitude adventurer’s camp set on a snowy mountain peak. A small tent, a firepit, climbing gear, and an ice axe stuck in the ground. Below, a breathtaking view of distant mountain ranges bathed in the first light of dawn. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-nRLcqTq8ROESplNwkt6NRNNX.png',
                'path_md' => 'images_md/img-nRLcqTq8ROESplNwkt6NRNNX.webp',
                'path_sm' => 'images_sm/img-nRLcqTq8ROESplNwkt6NRNNX.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 19:01:26',
                'updated_at' => '2025-03-23 04:17:02',
            ),
            26 => 
            array (
                'id' => 37,
                'user_id' => 1,
                'title' => 'Ancient Library Screen',
            'prompt' => 'A grand and mysterious library filled with towering bookshelves, ancient tomes, and glowing magical artifacts. Dust particles float in the dim golden light coming from chandeliers. An old wooden ladder leans against a shelf, inviting discovery. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-jolg3UHCTV9AW938tKvkDbrX.png',
                'path_md' => 'images_md/img-jolg3UHCTV9AW938tKvkDbrX.webp',
                'path_sm' => 'images_sm/img-jolg3UHCTV9AW938tKvkDbrX.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 19:00:22',
                'updated_at' => '2025-03-23 04:18:24',
            ),
            27 => 
            array (
                'id' => 35,
                'user_id' => 1,
                'title' => 'Tavern Interior Screen',
            'prompt' => 'A cozy medieval tavern interior with wooden beams, a roaring fireplace, and rustic wooden tables. Shelves stacked with dusty bottles of ale, barrels in the corner, and dim candlelight add to the warm and lively ambiance. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-Ho17fDoVWcDCQMqP7XChQo7i.png',
                'path_md' => 'images_md/img-Ho17fDoVWcDCQMqP7XChQo7i.webp',
                'path_sm' => 'images_sm/img-Ho17fDoVWcDCQMqP7XChQo7i.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:58:46',
                'updated_at' => '2025-03-23 04:19:44',
            ),
            28 => 
            array (
                'id' => 32,
                'user_id' => 1,
                'title' => 'Navigation Table Screen',
            'prompt' => 'A navigator’s wooden desk filled with a large parchment map, a brass compass, measuring tools, a spyglass, and various old navigation charts. The desk is illuminated by soft lantern light, creating a historical and adventurous atmosphere. Aspect ratio: portrait (tall image, 1024x1792)',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-Si1xF19CBF2Hr5LyNKx4gMGg.png',
                'path_md' => 'images_md/img-Si1xF19CBF2Hr5LyNKx4gMGg.webp',
                'path_sm' => 'images_sm/img-Si1xF19CBF2Hr5LyNKx4gMGg.webp',
                'is_public' => false,
                'created_at' => '2025-03-16 18:51:47',
                'updated_at' => '2025-03-23 04:31:51',
            ),
            29 => 
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
            30 => 
            array (
                'id' => 45,
                'user_id' => 1,
                'title' => 'Survivor',
                'prompt' => 'A rugged survivor in a post-apocalyptic wasteland, wearing a tattered hood and gas mask. Their armor is made from scavenged metal plates, and they clutch a makeshift energy rifle. Dust and smoke fill the air, with ruined skyscrapers in the background.',
                'has_glitches' => false,
                'attempts' => 1,
                'aspect' => 'portrait',
                'quality' => 'standard',
                'style' => 'vivid',
                'path' => 'images/img-9D76ll4tr05m0Ke7ufRYZnsX.png',
                'path_md' => 'images_md/img-9D76ll4tr05m0Ke7ufRYZnsX.webp',
                'path_sm' => 'images_sm/img-9D76ll4tr05m0Ke7ufRYZnsX.webp',
                'is_public' => false,
                'created_at' => '2025-03-28 05:30:25',
                'updated_at' => '2025-03-28 05:30:27',
            ),
        ));
        
        
    }
}