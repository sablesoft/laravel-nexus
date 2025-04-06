<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppGroupRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('app.group_roles')->delete();

        \DB::table('app.group_roles')->insert(array (
            0 =>
            array (
                'id' => 6,
                'application_id' => 2,
                'group_id' => 2,
                'role_id' => 6,
                'name' => 'Syndicate',
                'code' => 'syndicate',
                'description' => 'Operative of an organized shadow network — masters of influence, intimidation, and trade in secrets.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"gold": {"type": "int", "value": 150, "description": "Starting capital used for influence."}, "faction": {"type": "enum", "value": "black-hand", "options": ["black-hand", "silk-circle", "iron-coin"], "description": "Syndicate subgroup or branch."}, "secrets": {"type": "int", "value": 2, "description": "Amount of valuable intel held."}, "reputation": {"type": "int", "value": 5, "description": "Standing in the underground world."}}}',
            'behaviors' => '{"can": {"bribe": "chat.has(\'gold\') >= 200", "smuggle": true, "intimidate": "member.has(\'reputation\') > 4"}}',
                'created_at' => '2025-04-06 04:59:18',
                'updated_at' => '2025-04-06 04:59:18',
            ),
            1 =>
            array (
                'id' => 7,
                'application_id' => 2,
                'group_id' => 2,
                'role_id' => 7,
                'name' => 'The Order',
                'code' => 'order',
                'description' => 'A disciplined organization devoted to law, faith, or ancient principles. Bound by oaths and hierarchy.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"rank": {"type": "enum", "value": "initiate", "options": ["initiate", "knight", "commander"], "description": "Position within the hierarchy of the Order."}, "faith": {"type": "bool", "value": true, "description": "Adherence to the doctrines of the Order."}, "oaths": {"type": "int", "value": 1, "description": "Number of sworn binding commitments."}, "discipline": {"type": "int", "value": 6, "description": "Mental and emotional rigidity and focus."}}}',
            'behaviors' => '{"can": {"judge": "member.has(\'discipline\') >= 5", "protect": "member.has(\'rank\') === \'knight\'", "invoke_oath": true}}',
                'created_at' => '2025-04-06 05:00:18',
                'updated_at' => '2025-04-06 05:00:18',
            ),
            2 =>
            array (
                'id' => 1,
                'application_id' => 2,
                'group_id' => 1,
                'role_id' => 1,
                'name' => 'Noble',
                'code' => 'noble',
                'description' => 'Born into a life of privilege, trained in diplomacy and control.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"gold": {"type": "int", "value": 120, "description": "Inherited wealth."}, "charisma": {"type": "int", "value": 5, "description": "Charm and persuasive presence."}, "influence": {"type": "int", "value": 6, "description": "Ability to assert authority and status."}, "allegiance": {"type": "enum", "value": "empire", "options": ["empire", "rebels", "neutral"], "description": "Declared political loyalty."}}}',
            'behaviors' => '{"can": {"bribe": "chat.has(\'gold\') >= 100", "command": true, "intimidate": "member.has(\'influence\') > 5"}}',
                'created_at' => '2025-04-06 04:42:35',
                'updated_at' => '2025-04-06 04:46:39',
            ),
            3 =>
            array (
                'id' => 2,
                'application_id' => 2,
                'group_id' => 1,
                'role_id' => 2,
                'name' => 'Orphan',
                'code' => 'orphan',
                'description' => 'Grew up without guidance, but learned to survive through resilience.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"luck": {"type": "int", "value": 4, "description": "Natural tendency to avoid disaster."}, "origin": {"type": "enum", "value": "streets", "options": ["streets", "orphanage", "unknown"], "description": "Where the orphan was raised."}, "stealth": {"type": "int", "value": 5, "description": "Ability to remain unseen."}, "charisma": {"type": "int", "value": 2, "description": "Unrefined charm developed on the streets."}}}',
            'behaviors' => '{"can": {"hide": true, "charm": "member.has(\'luck\') > 3 && member.has(\'charisma\') > 2", "steal": "chat.has(\'gold\') > 0"}}',
                'created_at' => '2025-04-06 04:43:29',
                'updated_at' => '2025-04-06 04:47:00',
            ),
            4 =>
            array (
                'id' => 3,
                'application_id' => 2,
                'group_id' => 1,
                'role_id' => 3,
                'name' => 'Outlander',
                'code' => 'outlander',
                'description' => 'A stranger from distant lands, bearer of exotic knowledge and outsider instincts.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"barter": {"type": "int", "value": 3, "description": "Skill in exchanging goods without currency."}, "culture": {"type": "enum", "value": "desert-tribes", "options": ["desert-tribes", "mountain-clans", "isle-nations"], "description": "Cultural background influencing worldview."}, "respect": {"type": "int", "value": 1, "description": "Earned standing in local society."}, "languages": {"type": "int", "value": 2, "description": "Number of non-native languages known."}}}',
            'behaviors' => '{"can": {"trade": "member.has(\'barter\') >= 3", "navigate": true, "speakAncient": "member.has(\'languages\') >= 2"}}',
                'created_at' => '2025-04-06 04:49:14',
                'updated_at' => '2025-04-06 04:49:14',
            ),
            5 =>
            array (
                'id' => 4,
                'application_id' => 2,
                'group_id' => 1,
                'role_id' => 4,
                'name' => 'Refugee',
                'code' => 'refugee',
                'description' => 'Driven from home by conflict, resilient and resourceful in times of hardship.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"status": {"type": "enum", "value": "displaced", "options": ["displaced", "asylum", "integrated"], "description": "Current legal or social standing."}, "alertness": {"type": "int", "value": 3, "description": "Awareness of surroundings and danger."}, "dependents": {"type": "int", "value": 1, "description": "Number of people the character cares for."}, "resilience": {"type": "int", "value": 4, "description": "Mental and emotional endurance."}}}',
            'behaviors' => '{"can": {"beg": true, "adapt": "member.has(\'resilience\') >= 3", "evade": "member.has(\'alertness\') > 4"}}',
                'created_at' => '2025-04-06 04:51:07',
                'updated_at' => '2025-04-06 04:51:07',
            ),
            6 =>
            array (
                'id' => 5,
                'application_id' => 2,
                'group_id' => 2,
                'role_id' => 5,
                'name' => 'Rebellion',
                'code' => 'rebellion',
                'description' => 'Part of an underground movement. Values freedom over order, always watching for a chance to strike.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"rank": {"type": "enum", "value": "cell-agent", "options": ["sympathizer", "cell-agent", "strategist"], "description": "Level of responsibility within the movement."}, "loyalty": {"type": "int", "value": 2, "description": "Apparent loyalty to the ruling system."}, "contacts": {"type": "int", "value": 3, "description": "Number of known allies in the network."}, "conviction": {"type": "int", "value": 5, "description": "Strength of belief in the cause."}}}',
            'behaviors' => '{"can": {"signal": true, "inspire": "member.has(\'conviction\') >= 5", "sabotage": "member.has(\'loyalty\') < 3"}}',
                'created_at' => '2025-04-06 04:58:10',
                'updated_at' => '2025-04-06 04:58:10',
            ),
            7 =>
            array (
                'id' => 8,
                'application_id' => 2,
                'group_id' => 2,
                'role_id' => 8,
                'name' => 'Nomads',
                'code' => 'nomads',
                'description' => 'Wanderers of the world, driven by survival, freedom, or ancient traditions. Adaptable and hard to pin down.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"herds": {"type": "int", "value": 2, "description": "Number of animals or valuable supplies."}, "origin": {"type": "enum", "value": "desert", "options": ["desert", "steppe", "mountain", "oasis"], "description": "Homeland or cultural background."}, "campfire": {"type": "bool", "value": true, "description": "Can establish a temporary resting point."}, "endurance": {"type": "int", "value": 5, "description": "Ability to withstand hardship and long travel."}}}',
            'behaviors' => '{"can": {"evade": true, "scout": "member.has(\'endurance\') > 4", "trade": "chat.has(\'campfire\') === true"}}',
                'created_at' => '2025-04-06 05:00:31',
                'updated_at' => '2025-04-06 05:00:31',
            ),
            8 =>
            array (
                'id' => 9,
                'application_id' => 2,
                'group_id' => 3,
                'role_id' => 9,
                'name' => 'Telepath',
                'code' => 'telepath',
                'description' => 'Possesses the ability to perceive or influence thoughts, emotions, or minds of others.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"range": {"type": "int", "value": 2, "description": "Effective psychic distance in zones or rooms."}, "clarity": {"type": "int", "value": 7, "description": "Focus and sensitivity to mental noise."}, "fatigue": {"type": "int", "value": 1, "description": "Mental strain accumulated from recent use."}, "link_active": {"type": "bool", "value": false, "description": "Is currently maintaining a mind link."}}}',
            'behaviors' => '{"can": {"link": "member.has(\'range\') >= 2", "read_mind": "member.has(\'clarity\') > 6", "detect_lie": true}}',
                'created_at' => '2025-04-06 05:01:43',
                'updated_at' => '2025-04-06 05:01:43',
            ),
            9 =>
            array (
                'id' => 10,
                'application_id' => 2,
                'group_id' => 3,
                'role_id' => 10,
                'name' => 'Tinkerer',
                'code' => 'tinkerer',
                'description' => 'Inventor and modifier of devices, known for creativity, precision, and unconventional problem-solving.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"focus": {"type": "int", "value": 5, "description": "Ability to concentrate on intricate tasks."}, "tools": {"type": "bool", "value": true, "description": "Has a toolkit available."}, "blueprints": {"type": "int", "value": 1, "description": "Number of known upgrade plans."}, "gadget_parts": {"type": "int", "value": 3, "description": "Parts available for crafting."}}}',
            'behaviors' => '{"can": {"repair": "member.has(\'tools\') === true", "enhance": "member.has(\'blueprints\') > 0", "improvise": true}}',
                'created_at' => '2025-04-06 05:02:00',
                'updated_at' => '2025-04-06 05:02:00',
            ),
            10 =>
            array (
                'id' => 11,
                'application_id' => 2,
                'group_id' => 3,
                'role_id' => 11,
                'name' => 'Diplomat',
                'code' => 'diplomat',
                'description' => 'Master of negotiation, persuasion, and maintaining fragile alliances. Balances tension with charm.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"tension": {"type": "int", "value": 2, "description": "Current level of interpersonal or political stress."}, "charisma": {"type": "int", "value": 7, "description": "Personal appeal and persuasive ability."}, "language_pack": {"type": "bool", "value": true, "description": "Carries translation tools for alien or foreign communication."}, "favored_faction": {"type": "enum", "value": "Neutral", "options": ["Neutral", "Order", "Rebellion"], "description": "Current political alignment."}}}',
            'behaviors' => '{"can": {"ally": "chat.has(\'trust_level\') >= 3", "negotiate": "member.has(\'charisma\') > 6", "deescalate": "member.has(\'tension\') < 5"}}',
                'created_at' => '2025-04-06 05:02:26',
                'updated_at' => '2025-04-06 05:02:26',
            ),
            11 =>
            array (
                'id' => 12,
                'application_id' => 2,
                'group_id' => 3,
                'role_id' => 12,
                'name' => 'Watcher',
                'code' => 'watcher',
                'description' => 'Silent observer of truths. Gathers intelligence and notices what others miss.',
                'limit' => 0,
                'screen_id' => NULL,
                'states' => '{"has": {"clarity": {"type": "int", "value": 5, "description": "Perception and attention to subtle cues."}, "insight": {"type": "int", "value": 7, "description": "Ability to deduce hidden intentions or truths."}, "observation_mode": {"type": "enum", "value": "Passive", "options": ["Passive", "Focused", "Covert"], "description": "Current observation strategy."}, "recording_device": {"type": "bool", "value": true, "description": "Carries a device for gathering data."}}}',
            'behaviors' => '{"can": {"cast": "member.has(\'insight\') > 6", "record": "member.has(\'clarity\') > 4", "observe": true}}',
                'created_at' => '2025-04-06 05:02:42',
                'updated_at' => '2025-04-06 05:02:42',
            ),
        ));


    }
}
