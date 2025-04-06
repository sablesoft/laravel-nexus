<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', config('admin.email'))->first() ?:
                User::factory()->create();
        $roles = [
            // Origin Roles
            [
                'name' => 'Noble',
                'description' => 'Born into a life of privilege, trained in diplomacy and control.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'command' => true,
                        'bribe' => "chat.has('gold') >= 100",
                        'intimidate' => "member.has('influence') > 5",
                    ],
                ],
                'states' => [
                    'has' => [
                        'influence' => [
                            'type' => 'int',
                            'value' => 6,
                            'description' => 'Ability to assert authority and status.',
                        ],
                        'charisma' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Charm and persuasive presence.',
                        ],
                        'gold' => [
                            'type' => 'int',
                            'value' => 120,
                            'description' => 'Inherited wealth.',
                        ],
                        'allegiance' => [
                            'type' => 'enum',
                            'value' => 'empire',
                            'options' => ['empire', 'rebels', 'neutral'],
                            'description' => 'Declared political loyalty.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Orphan',
                'description' => 'Grew up without guidance, but learned to survive through resilience.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'steal' => "chat.has('gold') > 0",
                        'hide' => true,
                        'charm' => "member.has('luck') > 3 && member.has('charisma') > 2",
                    ],
                ],
                'states' => [
                    'has' => [
                        'stealth' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Ability to remain unseen.',
                        ],
                        'luck' => [
                            'type' => 'int',
                            'value' => 4,
                            'description' => 'Natural tendency to avoid disaster.',
                        ],
                        'charisma' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Unrefined charm developed on the streets.',
                        ],
                        'origin' => [
                            'type' => 'enum',
                            'value' => 'streets',
                            'options' => ['streets', 'orphanage', 'unknown'],
                            'description' => 'Where the orphan was raised.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Outlander',
                'description' => 'A stranger from distant lands, bearer of exotic knowledge and outsider instincts.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'navigate' => true,
                        'trade' => "member.has('barter') >= 3",
                        'speakAncient' => "member.has('languages') >= 2",
                    ],
                ],
                'states' => [
                    'has' => [
                        'barter' => [
                            'type' => 'int',
                            'value' => 3,
                            'description' => 'Skill in exchanging goods without currency.',
                        ],
                        'languages' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Number of non-native languages known.',
                        ],
                        'culture' => [
                            'type' => 'enum',
                            'value' => 'desert-tribes',
                            'options' => ['desert-tribes', 'mountain-clans', 'isle-nations'],
                            'description' => 'Cultural background influencing worldview.',
                        ],
                        'respect' => [
                            'type' => 'int',
                            'value' => 1,
                            'description' => 'Earned standing in local society.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Refugee',
                'description' => 'Driven from home by conflict, resilient and resourceful in times of hardship.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'beg' => true,
                        'evade' => "member.has('alertness') > 4",
                        'adapt' => "member.has('resilience') >= 3",
                    ],
                ],
                'states' => [
                    'has' => [
                        'resilience' => [
                            'type' => 'int',
                            'value' => 4,
                            'description' => 'Mental and emotional endurance.',
                        ],
                        'alertness' => [
                            'type' => 'int',
                            'value' => 3,
                            'description' => 'Awareness of surroundings and danger.',
                        ],
                        'status' => [
                            'type' => 'enum',
                            'value' => 'displaced',
                            'options' => ['displaced', 'asylum', 'integrated'],
                            'description' => 'Current legal or social standing.',
                        ],
                        'dependents' => [
                            'type' => 'int',
                            'value' => 1,
                            'description' => 'Number of people the character cares for.',
                        ],
                    ],
                ],
            ],

            // Faction Roles
            [
                'name' => 'Rebellion',
                'description' => 'Part of an underground movement. Values freedom over order, always watching for a chance to strike.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'sabotage' => "member.has('loyalty') < 3",
                        'inspire' => "member.has('conviction') >= 5",
                        'signal' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'loyalty' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Apparent loyalty to the ruling system.',
                        ],
                        'conviction' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Strength of belief in the cause.',
                        ],
                        'rank' => [
                            'type' => 'enum',
                            'value' => 'cell-agent',
                            'options' => ['sympathizer', 'cell-agent', 'strategist'],
                            'description' => 'Level of responsibility within the movement.',
                        ],
                        'contacts' => [
                            'type' => 'int',
                            'value' => 3,
                            'description' => 'Number of known allies in the network.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Syndicate',
                'description' => 'Operative of an organized shadow network — masters of influence, intimidation, and trade in secrets.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'intimidate' => "member.has('reputation') > 4",
                        'bribe' => "chat.has('gold') >= 200",
                        'smuggle' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'reputation' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Standing in the underground world.',
                        ],
                        'gold' => [
                            'type' => 'int',
                            'value' => 150,
                            'description' => 'Starting capital used for influence.',
                        ],
                        'faction' => [
                            'type' => 'enum',
                            'value' => 'black-hand',
                            'options' => ['black-hand', 'silk-circle', 'iron-coin'],
                            'description' => 'Syndicate subgroup or branch.',
                        ],
                        'secrets' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Amount of valuable intel held.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'The Order',
                'description' => 'A disciplined organization devoted to law, faith, or ancient principles. Bound by oaths and hierarchy.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'judge' => "member.has('discipline') >= 5",
                        'protect' => "member.has('rank') === 'knight'",
                        'invoke_oath' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'discipline' => [
                            'type' => 'int',
                            'value' => 6,
                            'description' => 'Mental and emotional rigidity and focus.',
                        ],
                        'faith' => [
                            'type' => 'bool',
                            'value' => true,
                            'description' => 'Adherence to the doctrines of the Order.',
                        ],
                        'rank' => [
                            'type' => 'enum',
                            'value' => 'initiate',
                            'options' => ['initiate', 'knight', 'commander'],
                            'description' => 'Position within the hierarchy of the Order.',
                        ],
                        'oaths' => [
                            'type' => 'int',
                            'value' => 1,
                            'description' => 'Number of sworn binding commitments.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Nomads',
                'description' => 'Wanderers of the world, driven by survival, freedom, or ancient traditions. Adaptable and hard to pin down.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'scout' => "member.has('endurance') > 4",
                        'trade' => "chat.has('campfire') === true",
                        'evade' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'endurance' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Ability to withstand hardship and long travel.',
                        ],
                        'herds' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Number of animals or valuable supplies.',
                        ],
                        'origin' => [
                            'type' => 'enum',
                            'value' => 'desert',
                            'options' => ['desert', 'steppe', 'mountain', 'oasis'],
                            'description' => 'Homeland or cultural background.',
                        ],
                        'campfire' => [
                            'type' => 'bool',
                            'value' => true,
                            'description' => 'Can establish a temporary resting point.',
                        ],
                    ],
                ],
            ],

            // Trait Roles
            [
                'name' => 'Telepath',
                'description' => 'Possesses the ability to perceive or influence thoughts, emotions, or minds of others.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'read-mind' => "member.has('clarity') > 6",
                        'link' => "member.has('range') >= 2",
                        'detect_lie' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'clarity' => [
                            'type' => 'int',
                            'value' => 7,
                            'description' => 'Focus and sensitivity to mental noise.',
                        ],
                        'range' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Effective psychic distance in zones or rooms.',
                        ],
                        'link_active' => [
                            'type' => 'bool',
                            'value' => false,
                            'description' => 'Is currently maintaining a mind link.',
                        ],
                        'fatigue' => [
                            'type' => 'int',
                            'value' => 1,
                            'description' => 'Mental strain accumulated from recent use.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Tinkerer',
                'description' => 'Inventor and modifier of devices, known for creativity, precision, and unconventional problem-solving.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'repair' => "member.has('tools') === true",
                        'enhance' => "member.has('blueprints') > 0",
                        'improvise' => true,
                    ],
                ],
                'states' => [
                    'has' => [
                        'tools' => [
                            'type' => 'bool',
                            'value' => true,
                            'description' => 'Has a toolkit available.',
                        ],
                        'blueprints' => [
                            'type' => 'int',
                            'value' => 1,
                            'description' => 'Number of known upgrade plans.',
                        ],
                        'gadget_parts' => [
                            'type' => 'int',
                            'value' => 3,
                            'description' => 'Parts available for crafting.',
                        ],
                        'focus' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Ability to concentrate on intricate tasks.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Diplomat',
                'description' => 'Master of negotiation, persuasion, and maintaining fragile alliances. Balances tension with charm.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'negotiate' => "member.has('charisma') > 6",
                        'deescalate' => "member.has('tension') < 5",
                        'ally' => "chat.has('trust_level') >= 3",
                    ],
                ],
                'states' => [
                    'has' => [
                        'charisma' => [
                            'type' => 'int',
                            'value' => 7,
                            'description' => 'Personal appeal and persuasive ability.',
                        ],
                        'tension' => [
                            'type' => 'int',
                            'value' => 2,
                            'description' => 'Current level of interpersonal or political stress.',
                        ],
                        'language_pack' => [
                            'type' => 'bool',
                            'value' => true,
                            'description' => 'Carries translation tools for alien or foreign communication.',
                        ],
                        'favored_faction' => [
                            'type' => 'enum',
                            'value' => 'Neutral',
                            'options' => ['Neutral', 'Order', 'Rebellion'],
                            'description' => 'Current political alignment.',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Watcher',
                'description' => 'Silent observer of truths. Gathers intelligence and notices what others miss.',
                'is_public' => true,
                'behaviors' => [
                    'can' => [
                        'observe' => true,
                        'record' => "member.has('clarity') > 4",
                        'cast' => "member.has('insight') > 6",
                    ],
                ],
                'states' => [
                    'has' => [
                        'clarity' => [
                            'type' => 'int',
                            'value' => 5,
                            'description' => 'Perception and attention to subtle cues.',
                        ],
                        'insight' => [
                            'type' => 'int',
                            'value' => 7,
                            'description' => 'Ability to deduce hidden intentions or truths.',
                        ],
                        'recording_device' => [
                            'type' => 'bool',
                            'value' => true,
                            'description' => 'Carries a device for gathering data.',
                        ],
                        'observation_mode' => [
                            'type' => 'enum',
                            'value' => 'Passive',
                            'options' => ['Passive', 'Focused', 'Covert'],
                            'description' => 'Current observation strategy.',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($roles as $role) {
            Role::factory()->for($user)->create($role);
        }
    }
}
