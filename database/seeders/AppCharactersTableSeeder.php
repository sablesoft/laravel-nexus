<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppCharactersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.characters')->delete();
        
        \DB::table('app.characters')->insert(array (
            0 => 
            array (
                'id' => 3,
                'mask_id' => 1,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:55',
                'updated_at' => '2025-04-12 01:58:55',
            ),
            1 => 
            array (
                'id' => 2,
                'mask_id' => 4,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:47',
                'updated_at' => '2025-04-12 01:58:47',
            ),
            2 => 
            array (
                'id' => 1,
                'mask_id' => 3,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'player',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:50:33',
                'updated_at' => '2025-04-17 02:09:09',
            ),
            3 => 
            array (
                'id' => 4,
                'mask_id' => 2,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'player',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:59:03',
                'updated_at' => '2025-04-17 02:09:28',
            ),
            4 => 
            array (
                'id' => 73,
                'mask_id' => 1,
                'application_id' => NULL,
                'chat_id' => 18,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => '{"can": {"hit": {"to": "Direction or impact result — e.g. panel, knock, leg, wheel.", "for": "Purpose — e.g. signal, force, entry.", "how": "Tone or force — e.g. hard, lightly.", "from": "The origin and stance — e.g. standing, distance.", "what": "The target, surface or object being struck.", "using": "The body part or object used to hit — e.g. foot, hand, stick, pillow.", "description": "Used to create contact with force, including hitting, knocking or striking."}, "look": {"to": "The focus point — e.g. door, person.", "for": "The goal — e.g. clue, threat, analyze.", "how": "The manner or attentiveness — e.g. quickly, intently.", "from": "The position and point of view — e.g. behind, corner, top, tower.", "what": "The object, area or direction being observed.", "using": "The part, object or tool used for looking — e.g. eyes, telescope, window.", "description": "Used to visually examine or observe something."}, "move": {"to": "The destination or direction — e.g. window, corner, back, right, forest.", "for": "The purpose or reason for movement — e.g. escape, exploration, quest.", "how": "The manner or tone of the movement — e.g. quietly, slowly, carefully.", "from": "The origin or starting point — e.g. table, cover, city, room.", "what": "The object the character moves toward or through.", "using": "The tool, transfer, tranport, method, or aid used to perform the movement — e.g. legs, stealth, road, car.", "description": "Used to describe any physical relocation or movement of the character or an object — including walking, sneaking, shifting, or dragging items or oneself."}, "open": {"to": "The resulting state — e.g. open, gap.", "for": "The reason for opening — e.g. access, inspection, enter.", "how": "The manner or effort — e.g. gently, forcefully.", "from": "The origin or closed state — e.g. sealed, locked.", "what": "The object being opened — e.g. door, box, car.", "using": "The tool or body part used to open something — e.g. hand, crowbar, key.", "description": "Used to open containers, passages or other closeable objects."}, "take": {"to": "Where the object is placed after taking — e.g. inventory, bag, hand, pockets.", "for": "The intent and purpose — e.g. storage, defense.", "how": "The way the object is taken — e.g. quickly, carefully.", "from": "Where the object is taken from — e.g. floor, table, inventory.", "what": "The object being taken.", "using": "The hand, tool, or method used to take something — e.g. fingers, glove.", "description": "Used to pick up, grab or put objects from/to the environment."}, "listen": {"to": "Direction of focus — e.g. up, under, behind.", "for": "Expected sound — e.g. steps, conversation, song.", "how": "Tone of attention — e.g. attentively, silently.", "from": "Origin or positioning — e.g. ground, corner, shadow.", "what": "The area, object or source being listened to — e.g. forest, wall, outside, box, bird.", "using": "The part or tool used — e.g. ear, stethoscope.", "description": "Used to perceive auditory information."}, "search": {"to": "Final place where results may end up — e.g. inventory.", "for": "Target of the search — e.g. key, clue, loot.", "how": "Thoroughness or method — e.g. quickly, nervously.", "from": "Starting point or boundary — e.g. bag, drawer.", "what": "The object or area being searched.", "using": "Tools, items or body parts used to perform search — e.g. hand, stick, scanner.", "description": "Used for close or physical inspection to locate hidden objects or information."}}}',
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            5 => 
            array (
                'id' => 74,
                'mask_id' => 4,
                'application_id' => NULL,
                'chat_id' => 18,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => '{"can": {"hit": {"to": "Direction or impact result — e.g. panel, knock, leg, wheel.", "for": "Purpose — e.g. signal, force, entry.", "how": "Tone or force — e.g. hard, lightly.", "from": "The origin and stance — e.g. standing, distance.", "what": "The target, surface or object being struck.", "using": "The body part or object used to hit — e.g. foot, hand, stick, pillow.", "description": "Used to create contact with force, including hitting, knocking or striking."}, "look": {"to": "The focus point — e.g. door, person.", "for": "The goal — e.g. clue, threat, analyze.", "how": "The manner or attentiveness — e.g. quickly, intently.", "from": "The position and point of view — e.g. behind, corner, top, tower.", "what": "The object, area or direction being observed.", "using": "The part, object or tool used for looking — e.g. eyes, telescope, window.", "description": "Used to visually examine or observe something."}, "move": {"to": "The destination or direction — e.g. window, corner, back, right, forest.", "for": "The purpose or reason for movement — e.g. escape, exploration, quest.", "how": "The manner or tone of the movement — e.g. quietly, slowly, carefully.", "from": "The origin or starting point — e.g. table, cover, city, room.", "what": "The object the character moves toward or through.", "using": "The tool, transfer, tranport, method, or aid used to perform the movement — e.g. legs, stealth, road, car.", "description": "Used to describe any physical relocation or movement of the character or an object — including walking, sneaking, shifting, or dragging items or oneself."}, "open": {"to": "The resulting state — e.g. open, gap.", "for": "The reason for opening — e.g. access, inspection, enter.", "how": "The manner or effort — e.g. gently, forcefully.", "from": "The origin or closed state — e.g. sealed, locked.", "what": "The object being opened — e.g. door, box, car.", "using": "The tool or body part used to open something — e.g. hand, crowbar, key.", "description": "Used to open containers, passages or other closeable objects."}, "take": {"to": "Where the object is placed after taking — e.g. inventory, bag, hand, pockets.", "for": "The intent and purpose — e.g. storage, defense.", "how": "The way the object is taken — e.g. quickly, carefully.", "from": "Where the object is taken from — e.g. floor, table, inventory.", "what": "The object being taken.", "using": "The hand, tool, or method used to take something — e.g. fingers, glove.", "description": "Used to pick up, grab or put objects from/to the environment."}, "listen": {"to": "Direction of focus — e.g. up, under, behind.", "for": "Expected sound — e.g. steps, conversation, song.", "how": "Tone of attention — e.g. attentively, silently.", "from": "Origin or positioning — e.g. ground, corner, shadow.", "what": "The area, object or source being listened to — e.g. forest, wall, outside, box, bird.", "using": "The part or tool used — e.g. ear, stethoscope.", "description": "Used to perceive auditory information."}, "search": {"to": "Final place where results may end up — e.g. inventory.", "for": "Target of the search — e.g. key, clue, loot.", "how": "Thoroughness or method — e.g. quickly, nervously.", "from": "Starting point or boundary — e.g. bag, drawer.", "what": "The object or area being searched.", "using": "Tools, items or body parts used to perform search — e.g. hand, stick, scanner.", "description": "Used for close or physical inspection to locate hidden objects or information."}}}',
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            6 => 
            array (
                'id' => 75,
                'mask_id' => 3,
                'application_id' => NULL,
                'chat_id' => 18,
                'user_id' => 1,
                'screen_id' => 2,
                'actor' => 'player',
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => '{"can": {"hit": {"to": "Direction or impact result — e.g. panel, knock, leg, wheel.", "for": "Purpose — e.g. signal, force, entry.", "how": "Tone or force — e.g. hard, lightly.", "from": "The origin and stance — e.g. standing, distance.", "what": "The target, surface or object being struck.", "using": "The body part or object used to hit — e.g. foot, hand, stick, pillow.", "description": "Used to create contact with force, including hitting, knocking or striking."}, "look": {"to": "The focus point — e.g. door, person.", "for": "The goal — e.g. clue, threat, analyze.", "how": "The manner or attentiveness — e.g. quickly, intently.", "from": "The position and point of view — e.g. behind, corner, top, tower.", "what": "The object, area or direction being observed.", "using": "The part, object or tool used for looking — e.g. eyes, telescope, window.", "description": "Used to visually examine or observe something."}, "move": {"to": "The destination or direction — e.g. window, corner, back, right, forest.", "for": "The purpose or reason for movement — e.g. escape, exploration, quest.", "how": "The manner or tone of the movement — e.g. quietly, slowly, carefully.", "from": "The origin or starting point — e.g. table, cover, city, room.", "what": "The object the character moves toward or through.", "using": "The tool, transfer, tranport, method, or aid used to perform the movement — e.g. legs, stealth, road, car.", "description": "Used to describe any physical relocation or movement of the character or an object — including walking, sneaking, shifting, or dragging items or oneself."}, "open": {"to": "The resulting state — e.g. open, gap.", "for": "The reason for opening — e.g. access, inspection, enter.", "how": "The manner or effort — e.g. gently, forcefully.", "from": "The origin or closed state — e.g. sealed, locked.", "what": "The object being opened — e.g. door, box, car.", "using": "The tool or body part used to open something — e.g. hand, crowbar, key.", "description": "Used to open containers, passages or other closeable objects."}, "take": {"to": "Where the object is placed after taking — e.g. inventory, bag, hand, pockets.", "for": "The intent and purpose — e.g. storage, defense.", "how": "The way the object is taken — e.g. quickly, carefully.", "from": "Where the object is taken from — e.g. floor, table, inventory.", "what": "The object being taken.", "using": "The hand, tool, or method used to take something — e.g. fingers, glove.", "description": "Used to pick up, grab or put objects from/to the environment."}, "listen": {"to": "Direction of focus — e.g. up, under, behind.", "for": "Expected sound — e.g. steps, conversation, song.", "how": "Tone of attention — e.g. attentively, silently.", "from": "Origin or positioning — e.g. ground, corner, shadow.", "what": "The area, object or source being listened to — e.g. forest, wall, outside, box, bird.", "using": "The part or tool used — e.g. ear, stethoscope.", "description": "Used to perceive auditory information."}, "search": {"to": "Final place where results may end up — e.g. inventory.", "for": "Target of the search — e.g. key, clue, loot.", "how": "Thoroughness or method — e.g. quickly, nervously.", "from": "Starting point or boundary — e.g. bag, drawer.", "what": "The object or area being searched.", "using": "Tools, items or body parts used to perform search — e.g. hand, stick, scanner.", "description": "Used for close or physical inspection to locate hidden objects or information."}}}',
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:56:31',
            ),
        ));
        
        
    }
}