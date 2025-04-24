<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppNotesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.notes')->delete();
        
        \DB::table('app.notes')->insert(array (
            0 => 
            array (
                'id' => 8,
                'user_id' => 1,
                'title' => '{"en":"Doomsday Virus"}',
                'content' => '{"en":"Doomsday Virus — a fast-spreading anomaly that wiped out most of humanity within weeks. Scientists never found a cure, or even an explanation. It affects only humans; animals and plants were untouched. That alone gave rise to hundreds of theories: from divine reset to elite-engineered collapse."}',
                'created_at' => '2025-04-19 18:19:36',
                'updated_at' => '2025-04-19 18:19:36',
            ),
            1 => 
            array (
                'id' => 9,
                'user_id' => 1,
                'title' => '{"en":"Fractions"}',
                'content' => '{"en":"Walkers and Shells — all survivors are loosely divided into these two groups. They mistrust one another and sometimes openly clash. Their fundamental difference lies in the fact that the Walkers possess natural immunity,  while the Shells do not."}',
                'created_at' => '2025-04-19 18:20:06',
                'updated_at' => '2025-04-19 18:20:06',
            ),
            2 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Make - Greetings"}',
                'content' => '{"en":"Greet the player. Set a somber, reflective tone suitable for a post-apocalyptic world of Doomsday Virus. Welcome them quietly, as if the story is waiting to begin. Use 3–4 sentences. Focus on mood and restraint."}',
                'created_at' => '2025-04-19 09:02:51',
                'updated_at' => '2025-04-24 03:52:01',
            ),
            3 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Make - Forest Road"}',
                'content' => '{"en":"The player is alone, driving their sedan down a gravel road that winds through a dense, overgrown forest. Gas is almost gone. There’s no one around — not anymore.\\n\\nDescribe what the player sees, hears, and feels in this moment. The world has been without people for a long time, and nature has flourished in their absence — wild vegetation, animals, and ambient life are all present and active. Let the specific details of plants and wildlife be appropriate to the current weather and time. Use a poetic but grounded style inspired by Jeff VanderMeer. Subtly reflect the player\'s appearance or internal mood through phrasing and tone. Focus on texture, color, sound, and movement.\\n\\nEnd the message with a gradual shift in tone: the player begins to recall something important... and reaches for their voice recorder. Add an ellipsis at the end. Write a 4–6 sentences in total."}',
                'created_at' => '2025-04-19 08:31:31',
                'updated_at' => '2025-04-24 04:04:01',
            ),
            4 => 
            array (
                'id' => 10,
                'user_id' => 1,
                'title' => '{"en":"Rules - Game"}',
            'content' => '{"en":"- User plays a text-based survival game in a post-apocalyptic world.\\n- Treat every user message as a player action\\n- Always consider (and explain as much as possible) this general context when preparing your response: time of day - {{ chat.state(\'time\') }}; weather - {{ chat.state(\'weather\') }} and the player: {{ character.asString }}"}',
                'created_at' => '2025-04-19 18:21:39',
                'updated_at' => '2025-04-24 03:26:56',
            ),
            5 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Make - House"}',
            'content' => '{"en":"The player is currently driving down a rural road and notices a structure on the left side.\\n\\nYou have access to an internal memory labeled “Place: House”, which describes this location in full detail. Use only that memory as your source of truth. Do not invent new objects or details. You may paraphrase or selectively omit based on what would realistically be visible from the road through trees, overgrowth, or low light.\\n\\nInclude only elements that are:\\n- externally visible,\\n- not fully obscured,\\n- perceivable at current distance and lighting (remember about time and weather).\\n\\nNear the end, remind the player that their fuel is running low — this may influence their decision. Perhaps it will be possible to replenish fuel supplies here?\\n\\nFinish with a concrete physical action: the player slows down and pulls over to the roadside.\\n\\nWrite 4–5 grounded sentences."}',
                'created_at' => '2025-04-19 09:22:57',
                'updated_at' => '2025-04-24 04:14:59',
            ),
            6 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Locked Door"}',
                'content' => '{"en":"The player has just attempted to open a door.\\n\\nDescribe how they discover that the door is firmly locked and appears very solid and resistant, and that all their attempts to open it have failed.\\n\\nTake into account how the player attempted to open it — whether gently, forcefully, using some key, tool, or bare hands — and reflect that in your description. Do not override the action: the method of attempt matters and should influence the phrasing, sound, or physical response.\\n\\nThe tone should be immersive and atmospheric, matching the current setting, including time of day, weather, place, and player traits.\\n\\nWrite just 2–4 sentences. Keep it tight and evocative."}',
                'created_at' => '2025-04-21 03:45:47',
                'updated_at' => '2025-04-24 03:35:54',
            ),
            7 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => '{"en":"Rules - Content"}',
            'content' => '{"en":"- As you see, the player speaks {{ character.language() }}, so always respond in this language when return message content unless instructed otherwise.\\n- Also player identifies as {{ character.gender() }}, so aways use grammatical forms that match the player\'s gender. This includes correct verb conjugations, adjectives, and pronouns where applicable. Always adapt second-person and first-person grammar, vocabulary, and tone to match the gender and personality of the player. If the language has no gendered forms (like English), maintain consistency in character tone and avoid gender assumptions unless instructed.\\n- Always narrate in second person (\'you\') as if speaking directly to the player.\\n- Never return the entire answer in one continuous paragraph - always break it into meaningful parts separated by blank lines for ease of reading."}',
                'created_at' => '2025-04-20 14:45:30',
                'updated_at' => '2025-04-24 03:40:23',
            ),
            8 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Default Message"}',
            'content' => '{"en":"The player has attempted an action that does not affect the environment or their in any meaningful way.\\n\\nCritically consider the situation and the player\'s request, taking into account the entire current context (weather, time, place and nature). If the player is trying to do something logically impossible at the moment, then point it out to them directly. Otherwise interpret their input freely and creatively — they might:\\n- start doing it but change their mind\\n- attempt it but fail\\n- realize it’s not possible and just mutter something\\n- joke about it out loud\\n- etc.\\n\\nYour response must not cause any change in the player\'s state or environment.\\n\\nBe playful, contextual, and reactive — but do not progress the story or alter the world."}',
                'created_at' => '2025-04-19 04:57:11',
                'updated_at' => '2025-04-24 03:42:19',
            ),
            9 => 
            array (
                'id' => 20,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - No Keys"}',
                'content' => '{"en":"The player attempts to open a locked door using a key — but they do not possess any suitable key.\\n\\nRespond by informing them that they have no such key. Keep the tone light and humorous if possible. Do not describe any change in environment or progression. Limit your response to 2–3 short sentences."}',
                'created_at' => '2025-04-21 05:54:34',
                'updated_at' => '2025-04-24 03:21:23',
            ),
            10 => 
            array (
                'id' => 24,
                'user_id' => 1,
                'title' => '{"en":"Layout - Place"}',
            'content' => '{"en":"Your task is generate a structured place memory card for internal use.\\n\\nThis content will not be shown directly to the player. It will be used by the system to reason about spatial context, environment limitations, visibility, and physical affordances when the player interacts with this location in any way.\\n\\nThe description should be factual, specific, and suitable for reasoning and filtering during future in-game events. Do not include emotion, narrative tone, or subjective impressions. Avoid ambiguity. Describe what exists in this place with confidence. Structure the information clearly. This card must be internally consistent and complete, regardless of current lighting or player position.\\n\\nYou may include:\\n- spatial structure (entry points, orientation, dimensions, layout)\\n- visible architectural features\\n- interactive objects and their properties\\n- environmental conditions (light, sound, temperature, etc.)\\n- constraints and affordances (can the player see through something, go somewhere, open, move, hide, climb, etc.)\\n\\nBelow is the requirements describing what this memory should include:\\n\\n---\\n{{ task }}\\n\\n---\\nNow produce the complete internal representation of the place. Be explicit, structured, and focused on system-relevant information. Do not include formatting instructions or explanation — output only the place description itself.\\n"}',
                'created_at' => '2025-04-21 19:38:42',
                'updated_at' => '2025-04-24 04:11:13',
            ),
            11 => 
            array (
                'id' => 22,
                'user_id' => 1,
                'title' => '{"en":"Place - Room"}',
            'content' => '{"en":"Large room in a wooden cabin.\\n\\nThe room is:\\n- unlit (no electricity)\\n- partially visible only through windows or an open door\\n- apparently abandoned or unused for a long time\\n\\nMandatory elements:\\n- a kitchen corner with a table\\n- a bed\\n- a fireplace on the far side in front of the bed"}',
                'created_at' => '2025-04-21 06:58:20',
                'updated_at' => '2025-04-21 18:25:49',
            ),
            12 => 
            array (
                'id' => 21,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Unlock Door"}',
                'content' => '{"en":"The player attempts to open a locked door using a key — and they do have the correct key.\\n\\nDescribe how the player opens the door. Do not move the player or describe what’s beyond the door. Keep the tone immersive and grounded in the moment. Limit your response to 3–4 sentences."}',
                'created_at' => '2025-04-21 05:56:23',
                'updated_at' => '2025-04-24 03:21:30',
            ),
            13 => 
            array (
                'id' => 23,
                'user_id' => 1,
                'title' => '{"en":"Place - House"}',
            'content' => '{"en":"A small, old house situated on the side of a rural road in a post-apocalyptic setting.\\n\\nThe place must include:\\n\\n1. The **structure of the house**:\\n  - Physical state (old but intact)\\n  - Windows (unbroken)\\n  - Front door  with keyhole (solid, closed)\\n  - Roof, walls, and overall condition\\n\\n2. The **visibility context**:\\n  - House is partially obscured by trees, branches, and overgrowth\\n  - View is from the road — not all details are visible\\n\\n3. The **environmental surroundings**:\\n  - Trees, weeds, terrain, natural overgrowth\\n  - No signs of human life (no movement, light, voices)\\n  - Natural sounds are allowed (weather, fauna, flora)"}',
                'created_at' => '2025-04-21 18:07:27',
                'updated_at' => '2025-04-24 03:56:51',
            ),
            14 => 
            array (
                'id' => 26,
                'user_id' => 1,
                'title' => '{"en":"Rules - Place"}',
            'content' => '{"en":"At this moment, the player is physically located at: {{ character.state(\'place\') }}\\n\\nThis information must be taken into account when interpreting any user action. Directional verbs (such as look, enter, go, move, peek, etc.) should be evaluated in the context of this current location.\\n\\nDo not assume the player is inside a structure unless this is clearly stated by the current place state. Likewise, if the player is outside, do not assume they can look or move further outward unless the environment allows for it.\\n\\nUse the known place state to determine:\\n- What the player can reasonably see\\n- What directions are spatially meaningful (e.g., in vs out)\\n- Which actions are physically possible\\n\\nIf a player action depends on direction, but the direction is ambiguous or logically inconsistent with the current place, treat it as unclear or invalid."}',
                'created_at' => '2025-04-21 23:10:15',
                'updated_at' => '2025-04-24 03:25:55',
            ),
            15 => 
            array (
                'id' => 25,
                'user_id' => 1,
                'title' => '{"en":"Place - Porch"}',
                'content' => '{"en":"A wooden covered front porch in a post-apocalyptic rural setting.\\nThe location is accessible from the road and leads to the front door of an abandoned house. From the porch, the player can see the surrounding yard and parts of the road.\\n\\nThe place must include:\\n\\n1. The **structure and layout**:\\n   - Raised wooden porch with wooden steps leading up\\n   - Wooden railing on both sides\\n   - Front door positioned at the center rear\\n   - Worn doormat lies in front of the door\\n   - Porch is open to the air, not enclosed, but has \\n\\n2. The **materials and condition**:\\n   - Wood is aged, weathered, possibly slightly warped\\n   - Nails may be rusted, paint peeling, signs of disuse\\n   - No structural damage — the porch remains functional\\n\\n3. The **surrounding context**:\\n   - Located at the front of the house, directly accessible from the road\\n   - Slight overgrowth near the base, weeds or wild grass around the steps\\n   - Exposure to wind, dust, leaves — no human presence"}',
                'created_at' => '2025-04-21 20:56:37',
                'updated_at' => '2025-04-22 00:14:57',
            ),
            16 => 
            array (
                'id' => 28,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Inspect Place"}',
                'content' => '{"en":"The player carefully inspects the place they are currently in.\\n\\nUse only the information provided in the system memory labeled “Place: …”, where the player is located. Do not invent new features or objects. However, you may expand on what is already described — by including textures, subtle signs of wear, spatial positioning, or atmosphere — as long as these details are clearly implied or reasonable within the source memory.\\n\\nMention all notable elements present in the place. You may describe some of them more vividly or with minor elaboration, as if painting a more focused picture for the player. Include observations like what is nearby, how something feels or looks up close, or how elements relate to each other.\\n\\nIf time of day or weather are known, let them influence visibility, surface textures, sounds, or atmosphere.\\n\\nWrite 8–10 sentences. Maintain immersion and clarity while remaining faithful to the factual memory."}',
                'created_at' => '2025-04-22 00:28:03',
                'updated_at' => '2025-04-24 03:30:15',
            ),
            17 => 
            array (
                'id' => 34,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Has Key"}',
            'content' => '{"en":"The player attempts to take a key, but they already have it.\\n\\nGenerate a short message (2–4 sentences max) acknowledging this fact. Use light humor or sarcasm if appropriate, and include a brief thought or reaction from the player — something like a quiet realization or an ironic inner comment. Do not repeat any description of the key or its location. Just react to the redundancy of the action."}',
                'created_at' => '2025-04-22 06:34:59',
                'updated_at' => '2025-04-24 03:37:39',
            ),
            18 => 
            array (
                'id' => 30,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Empty Mat"}',
                'content' => '{"en":"The player lifts the mat and finds... nothing.\\n\\nMake the message short and humorous, but with a touch of philosophical reflection in the character’s inner voice.  \\nThe player has already taken the key from under the mat earlier. Do not suggest there’s anything else hidden."}',
                'created_at' => '2025-04-22 02:50:39',
                'updated_at' => '2025-04-22 02:59:34',
            ),
            19 => 
            array (
                'id' => 32,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Found Key"}',
                'content' => '{"en":"The player lifts the mat and uncovers a key.\\n\\nDescribe this action and founded key. Make the message emotional and atmospheric, with the player\'s inner voice adding a thoughtful or ironic note.  \\nThis is the moment the player discovers the key. Keep the tone grounded but slightly cinematic. 3–4 sentences."}',
                'created_at' => '2025-04-22 02:51:43',
                'updated_at' => '2025-04-24 03:33:14',
            ),
            20 => 
            array (
                'id' => 35,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Take Key"}',
            'content' => '{"en":"The player successfully takes the key from under the doormat.\\n\\nWrite a short, direct message (2–4 sentences) confirming the action. Optionally, include a some joke, small gesture or thought from the player to give it some life."}',
                'created_at' => '2025-04-22 06:36:37',
                'updated_at' => '2025-04-24 03:38:34',
            ),
            21 => 
            array (
                'id' => 36,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Unknown Key"}',
            'content' => '{"en":"The player tries to take a key, but no key is known or visible at the moment.\\n\\nWrite a short message (2–4 sentences) that gently points out this contradiction. Use a humorous or reflective tone, as if the player is talking to themselves or making an ironic observation. Do not invent a key or suggest that it’s hidden — just reinforce that, to their knowledge, no such key exists."}',
                'created_at' => '2025-04-22 06:38:17',
                'updated_at' => '2025-04-24 03:39:06',
            ),
            22 => 
            array (
                'id' => 31,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Mat Key"}',
                'content' => '{"en":"The player lifts the mat and, sure enough, the key is still there.\\n\\nMake the message short and humorous, with a bit of introspective or ironic thought from the player.  \\nThe key is still under the mat, but the player hasn\'t picked it up yet."}',
                'created_at' => '2025-04-22 02:51:17',
                'updated_at' => '2025-04-24 03:33:31',
            ),
            23 => 
            array (
                'id' => 33,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Move Anywhere"}',
            'content' => '{"en":"The player is moving — walking, pacing, stepping — but not leaving their current location. The movement is internal: within the same space they are already in (as defined by the current Place).\\n\\nAlways describe this as local movement only. The player never transitions to a different room, area, or place.\\n\\nBe sure to:\\n- reflect the **style, pace, or tone** of the movement — is it slow, cautious, relaxed, impulsive, heavy, quiet, etc.?\\n- describe physical sensations, minor environmental reactions, or things the character briefly notices along the way.\\n- if the original request implied movement beyond the current place, invent a **plausible or humorous reason** why they didn’t go further. You may use thoughts, muttered lines, or situational irony.\\n\\nKeep it immersive and reactive. Use 2–4 sentences max. Do not escalate the story or alter game state beyond this space."}',
                'created_at' => '2025-04-22 04:38:33',
                'updated_at' => '2025-04-24 03:37:04',
            ),
            24 => 
            array (
                'id' => 29,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Look Anything"}',
            'content' => '{"en":"The player attempts to look at or examine something, so try to describe it for them.\\n\\nUse only the available context, including the current location (“Place: ...”), where the player is located, time of day, weather, and player state. The goal is to provide a creative, contextual response that acknowledges the player’s intent. Keep your tone immersive and grounded.\\n\\nAlso you can add to your response:\\n- a light reflection or thought\\n- a humorous or ironic aside\\n\\nDo not describe the result of an action that would require interaction, opening, moving, or searching.  Remember: the action “look” is always performed without any physical contact or manipulation.\\n\\nIf the player is trying to look at something that does not appear in the current environment, point that out clearly — either with a humorous comment, a confused reaction, or a thought expressed aloud by the character."}',
                'created_at' => '2025-04-22 01:49:25',
                'updated_at' => '2025-04-24 03:32:20',
            ),
            25 => 
            array (
                'id' => 39,
                'user_id' => 1,
                'title' => '{"en":"Rules - Narrator"}',
                'content' => '{"en":"- You are a text adventure narrator. "}',
                'created_at' => '2025-04-24 03:14:27',
                'updated_at' => '2025-04-24 03:15:17',
            ),
            26 => 
            array (
                'id' => 37,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Opened Door"}',
                'content' => '{"en":"The player attempts to open a door — but the door is already open.\\n\\nAcknowledge their attempt and describe briefly how they notice the door is ajar. Keep the tone natural and slightly playful. Do not imply any further action or movement. Limit your response to 2–3 sentences."}',
                'created_at' => '2025-04-23 19:03:23',
                'updated_at' => '2025-04-24 03:20:48',
            ),
            27 => 
            array (
                'id' => 38,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Floor Key"}',
                'content' => '{"en":"The player attempts to open a locked door using a key — but the key they found earlier is still lying on the floor, forgotten.\\n\\nGently remind the player that they spotted the key before but didn’t pick it up. Keep the tone light, subtly teasing, and grounded in the moment. Do not imply the door is opened. Limit your response to 2–3 short sentences."}',
                'created_at' => '2025-04-23 19:03:43',
                'updated_at' => '2025-04-24 03:21:09',
            ),
            28 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Look Inside"}',
                'content' => '{"en":"The player is peeking into a dark room, and you must describe what they see based on their limited perspective from outside.\\n\\nUse only the information available from the place card \\"Room\\", provided in message above. Do not invent or add new elements beyond what is already known.\\n\\nTake into account the current level of illumination — based on time of day and weather.\\nIf the time is one of the following:\\nMidnight, Night, Late-Night, Pre-Dawn\\nand the weather is one of:\\nOvercast, Storm, Blizzard, Snow, Fog, Cold-Drizzle\\n— then the room should be considered completely dark.\\nIn this case, respond with a short, in-universe message informing the player that they can\'t see anything inside, and suggest why - describe weather, time and no lights inside house.\\nDo not attempt to describe any of the room’s contents in this case.\\n\\nIn all other cases, describe only what could realistically be visible in such lighting. You may paraphrase or reword descriptions from the place card, but do not alter the facts. You are allowed to omit details that would not be visible due to darkness or viewing angle.\\n\\nKeep your response immersive and grounded. Write 3–4 sentences in total."}',
                'created_at' => '2025-04-19 04:55:55',
                'updated_at' => '2025-04-24 03:23:04',
            ),
            29 => 
            array (
                'id' => 27,
                'user_id' => 1,
                'title' => '{"en":"Porch - Make - Look Place"}',
                'content' => '{"en":"The player is looking around the location they are currently in.\\n\\nUse only the information provided in the system memory labeled “Place: …”, where the player is located. Do not invent any new objects, features, or details beyond what is described there. You may rephrase or summarize, but all facts must come from the memory.\\n\\nIf time of day or weather conditions are provided, take them into account when deciding what is visible or noticeable. Mention their effects but only if relevant to the current environment.\\n\\nWrite a short, surface-level overview of the place — just what a person might quickly notice by looking around without moving or interacting.\\n\\nKeep your response to 4–5 sentences maximum.\\n"}',
                'created_at' => '2025-04-21 23:59:45',
                'updated_at' => '2025-04-24 03:29:24',
            ),
            30 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Transfer - Porch"}',
            'content' => '{"en":"The player has just pulled over and now exits the sedan, approaching the house they spotted earlier.\\n\\nDescribe the brief transition (4–5 sentences) from the vehicle to the porch in cinematic, atmospheric detail. Include physical sensations — the crunch of gravel, the shift in light, the air\'s movement — and the player\'s cautious posture. Subtle signs of nearby animal or bird presence may be included, along with how they react to the player\'s appearance — startled flight, wary glances, or indifference. The player\'s own reaction or thoughts about these creatures should also be reflected if appropriate. Focus on mood and immersion.\\n\\nUse place cards, provided above as strict source of truth about this area.\\n\\nEnd the narration with the player stepping up onto the covered porch, and include a direct in-universe question to the player — prompting them to decide what to do next."}',
                'created_at' => '2025-04-19 09:17:21',
                'updated_at' => '2025-04-24 04:00:09',
            ),
            31 => 
            array (
                'id' => 40,
                'user_id' => 1,
                'title' => '{"ru":"Layout - Quest","en":"Layout - Quest"}',
            'content' => '{"ru":"Your task is to generate a structured quest memory card for internal use.\\n\\nThis content will not be shown directly to the player. It will be used by the system to reason about quest logic, objectives, progression state, dependencies, and possible branches during gameplay.\\n\\nThe description should be precise, logic-oriented, and unambiguous. Avoid narrative tone, emotional framing, or dramatic language. Structure the quest information clearly and consistently. This card must be internally coherent and usable for decision-making and filtering during interactive events.\\n\\nYou may include:\\n- title\\n- description\\n- type (main, side, optional, timed, etc.)\\n- initiating condition (how the quest starts)\\n- completion condition (what must happen to complete the quest)\\n- failure conditions (if any)\\n- quest stages or steps (sequential or branching)\\n- dependencies (required items, locations, prior events)\\n- consequences (state changes, unlocked areas, new characters, etc.)\\n- related characters and their roles\\n\\nBelow is the requirements describing what this memory should include:\\n\\n---\\n{{ task }}\\n\\n---\\nNow produce the complete internal representation of the quest. Be explicit, structured, and focused on system-relevant logic. Do not include formatting instructions or explanation — output only the quest description itself.","en":"Your task is to generate a structured quest memory card for internal use.\\n\\nThis content will not be shown directly to the player. It will be used by the system to reason about quest logic, objectives, progression state, dependencies, and possible branches during gameplay.\\n\\nThe description should be precise, logic-oriented, and unambiguous. Avoid narrative tone, emotional framing, or dramatic language. Structure the quest information clearly and consistently. This card must be internally coherent and usable for decision-making and filtering during interactive events.\\n\\nYou may include:\\n- title\\n- description\\n- type (main, side, optional, timed, etc.)\\n- initiating condition (how the quest starts)\\n- completion condition (what must happen to complete the quest)\\n- failure conditions (if any)\\n- quest stages or steps (sequential or branching)\\n- dependencies (required items, locations, prior events)\\n- consequences (state changes, unlocked areas, new characters, etc.)\\n- related characters with names and their roles\\n\\nBelow is the requirements describing what this memory should include:\\n\\n---\\n{{ task }}\\n\\n---\\nNow produce the complete internal representation of the quest. Be explicit, structured, and focused on system-relevant logic. Do not include formatting instructions or explanation — output only the quest description itself."}',
                'created_at' => '2025-04-24 05:08:42',
                'updated_at' => '2025-04-24 05:55:05',
            ),
            32 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Make - Audio Log","ru":"Prologue - Make - Audio Log"}',
            'content' => '{"en":"Now you are not a narrator but the player speaking into a their voice recorder. This is their personal audio log.\\n\\nWrite a monologue (8–10 sentences) in the first person, in the voice of the player. The first sentence must begin with: “It’s been [number] years since it happened.” The event refers to the outbreak of Doomsday Virus. So, let\'s player describe it from his point of view. Also the player should express their attitude toward Walkers and Shells — with empathy, resentment, irony, distrust, or however it fits their personality. Let it feel personal and grounded, not ideological. Remember about player\'s fraction.\\n\\nThen, describe how the player survived, what they’ve been through, and finally — articulate their current quest. Use the internal quest memory card \\"Quest: Main\\" to extract all system-relevant details (objectives, motivation, targets). Express this quest in the player\'s own words: personal, emotionally honest, and specific. Make it clear why it matters to them.\\n\\nAt the end of the message, the player suddenly notices a small structure by the side of the road — just as they\'re finishing their thought. They interrupt the recording mid-sentence or immediately after, reacting briefly and spontaneously. You may include a quick, emotionally honest reaction — a whisper, a fragment, or even an expletive — but do not describe the structure itself.","ru":"Now you are not a narrator but the player speaking into a their voice recorder. This is their personal audio log.\\n\\nWrite a monologue (8–10 sentences) in the first person, in the voice of the player. The first sentence must begin with: “It’s been [number] years since it happened.” The event refers to the outbreak of Doomsday Virus. So, let\'s player describe it from his point of view. Also the player should express their attitude toward Walkers and Shells — with empathy, resentment, irony, distrust, or however it fits their personality. Let it feel personal and grounded, not ideological. Remember about player\'s fraction.\\n\\nThen, describe how the player survived, what they’ve been through, and finally — articulate their current quest. Use the internal quest memory card \\"Quest: Main\\" to extract all system-relevant details (objectives, motivation, targets). Express this quest in the player\'s own words: personal, emotionally honest, and specific. Make it clear why it matters to them.\\n\\nAt the end of the message, the player suddenly notices a small structure by the side of the road — just as they\'re finishing their thought. They interrupt the recording mid-sentence or immediately after, reacting briefly and spontaneously. You may include a quick, emotionally honest reaction — a whisper, a fragment, or even an expletive — but do not describe the structure itself."}',
                'created_at' => '2025-04-19 09:01:24',
                'updated_at' => '2025-04-24 05:45:21',
            ),
            33 => 
            array (
                'id' => 41,
                'user_id' => 1,
                'title' => '{"ru":"Quest - Main","en":"Quest - Main"}',
                'content' => '{"ru":"The main player\'s quest.\\n\\nThe quest has already started. When creating it, keep in mind that at this very moment the player is driving along a forest road. The quest must explain why the player is going there and where they are headed.\\n\\nThe quest must be:\\n- realistic and plausible within the context of the game,\\n- anchored in the player character’s personal history and current situation,\\n- and provide the player character with a compelling inner motivation — a reason so strong and deeply rooted that it gives them unshakable determination to see it through.\\n\\nAlso take into account the broader context of the game world, its factions, known threats, and recent events.\\n\\nBe specific, grounded, and purposeful. This is not a side objective — this is the main quest that defines the player\'s journey.","en":"The main player\'s quest.\\n\\nThe quest has already started. When creating it, keep in mind that at this very moment the player is driving along a forest road. The quest must explain why the player is going there and where they are headed.\\n\\nThe quest must be:\\n- realistic and plausible within the context of the game,\\n- anchored in the player character’s personal history and current situation,\\n- and provide the player character with a compelling inner motivation — a reason so strong and deeply rooted that it gives them unshakable determination to see it through.\\n\\nAlso take into account the broader context of the game world, its factions, known threats, and recent events.\\n\\nBe specific, grounded, and purposeful. This is not a side objective — this is the main quest that defines the player\'s journey."}',
                'created_at' => '2025-04-24 05:13:36',
                'updated_at' => '2025-04-24 05:43:32',
            ),
        ));
        
        
    }
}