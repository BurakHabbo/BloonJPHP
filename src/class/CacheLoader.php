<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

Class CacheLoader {

    var $database;

    public function __construct(Database $database) {
        $this->database = $database;

        $this->LoadServerSettings();
        $this->LoadBans();
        $this->LoadRoles();
        $this->LoadHelpCategories();
        $this->LoadHelpTopics();
        $this->LoadSoundtracks();
        $this->LoadCataloguePages();
        $this->LoadCatalogueItems();
        $this->LoadNavigatorCategories();
        $this->LoadNavigatorPublics();
        $this->LoadRoomModels();
        $this->LoadRoomAds();
        $this->LoadBots();
        $this->LoadAchievements();
        $this->LoadChatFilter();
        $this->LoadQuests();
        $this->LoadGroups();
        $this->LoadHotelViewPromos();
        $this->LoadHotelViewRewardPromo();
        $this->LoadGiftWrappers();
        $this->LoadModerationPresets();
        $this->LoadEcotronRewards();
        $this->CleanDatabase();
    }

    public function LoadServerSettings() {
        if (isset($this->serversettings)) {
            unset($this->serversettings);
        }
        Console::Write("Loading Server Settings...");
        $this->serversettings = $this->database->Query("SELECT * FROM server_settings");
        Console::WriteLine("completed!");
    }

    public function LoadBans() {
        if (isset($this->bans)) {
            unset($this->bans);
        }
        Console::Write("Loading Bans...");
        $bans = $this->database->Query("SELECT * FROM bans");
        Console::WriteLine("completed!");
    }

    public function LoadRoles() {
        if (isset($this->permissions)) {
            unset($this->permissions);
        }
        Console::Write("Loading Roles...");
        $this->permissions = array();
        $this->permissions['ranks'] = $this->database->Query("SELECT * FROM permissions_ranks");
        $this->permissions['users'] = $this->database->Query("SELECT * FROM permissions_users");
        $this->permissions['vip'] = $this->database->Query("SELECT * FROM permissions_vip");
        Console::WriteLine("completed!");
    }

    public function LoadHelpCategories() {
        if (isset($this->helpcategories)) {
            unset($this->helpcategories);
        }
        Console::Write("Loading Help Categories...");
        $this->helpcategories = $this->database->Query("SELECT * FROM help_subjects");
        Console::WriteLine("completed!");
    }

    public function LoadHelpTopics() {
        if (isset($this->helptopics)) {
            unset($this->helptopics);
        }
        Console::Write("Loading Help Topics...");
        $this->helptopics = $this->database->Query("SELECT * FROM help_topics");
        Console::WriteLine("completed!");
    }

    public function LoadEcotronRewards() {
        if (isset($this->ecotronrewards)) {
            unset($this->ecotronrewards);
        }
        Console::Write("Loading Ecotron Rewards...");
        $this->ecotronrewards = array();
        $this->ecotronrewards['levels'] = array();
        $this->ecotronrewards['rewards'] = $this->database->Query("SELECT e.reward_level,f.public_name,f.type,f.sprite_id FROM ecotron_rewards e,furniture f WHERE e.item_id = f.id ORDER BY e.reward_level ASC");

        foreach ($this->ecotronrewards['rewards'] as $reward) {
            if (!in_array($reward['reward_level'], $this->ecotronrewards['levels'])) {
                $this->ecotronrewards['levels'][] = $reward['reward_level'];
            }
        }
        Console::WriteLine("completed!");
    }

    public function LoadModerationPresets() {
        if (isset($this->moderationpresets)) {
            unset($this->moderationpresets);
        }
        Console::Write("Loading Moderation Presets...");
        $this->moderationpresets = array();
        $this->moderationpresets['message'] = array();
        $this->moderationpresets['roommessage'] = array();

        $query = $this->database->Query("SELECT * FROM moderation_presets WHERE enabled = '1'");
        foreach ($query as $preset) {
            if ($preset['type'] == "message") {
                $this->moderationpresets['message'][] = $preset;
            } else {
                $this->moderationpresets['roommessage'][] = $preset;
            }
        }
        Console::WriteLine("completed!");
    }

    public function LoadGiftWrappers() {
        if (isset($this->giftwrappers)) {
            unset($this->giftwrappers);
        }
        Console::Write("Loading Gift Wrappers...");
        $this->giftwrappers = $this->database->Query("SELECT * FROM gift_wrappers ORDER BY baseid");
        Console::WriteLine("completed!");
    }

    public function LoadHotelViewRewardPromo() {
        if (isset($this->hotelviewrewardpromo)) {
            unset($this->hotelviewrewardpromo);
        }
        Console::Write("Loading HotelViewRewardPromo...");
        $this->hotelviewrewardpromo = $this->database->Query("SELECT * FROM hotelview_rewardpromo WHERE enabled = '1'");
        Console::WriteLine("completed!");
    }

    public function LoadHotelViewPromos() {
        if (isset($this->hotelviewpromos)) {
            unset($this->hotelviewpromos);
        }
        Console::Write("Loading HotelViewPromos...");
        $this->hotelviewpromos = $this->database->Query("SELECT * FROM hotelview_promos WHERE enabled = '1'");
        Console::WriteLine("completed!");
    }

    public function LoadSoundtracks() {
        if (isset($this->soundtracks)) {
            unset($this->soundtracks);
        }
        Console::Write("Loading Soundtracks...");
        $this->soundtracks = $this->database->Query("SELECT * FROM soundtracks");
        Console::WriteLine("completed!");
    }

    public function LoadCataloguePages() {
        if (isset($this->cataloguepages)) {
            unset($this->cataloguepages);
        }
        Console::Write("Loading Catalogue Pages...");
        $this->cataloguepages = $this->database->Query("SELECT * FROM catalog_pages ORDER BY order_num ASC");
        Console::WriteLine("completed!");
    }

    public function LoadCatalogueItems() {
        if (isset($this->catalogueitems)) {
            unset($this->catalogueitems);
        }
        Console::Write("Loading Catalogue Items...");
        $this->catalogueitems = $this->database->Query("SELECT * FROM catalog_items");
        Console::WriteLine("completed!");
    }

    public function LoadNavigatorCategories() {
        if (isset($this->navigatorcategories)) {
            unset($this->navigatorcategories);
        }
        Console::Write("Loading Navigator Categories...");
        $this->navigatorcategories = $this->database->Query("SELECT * FROM navigator_flatcats WHERE enabled = '1'");
        Console::WriteLine("completed!");
    }

    public function LoadNavigatorPublics() {
        if (isset($this->navigatorpublics)) {
            unset($this->navigatorpublics);
        }
        Console::Write("Loading Navigator Publics...");
        $this->navigatorpublics = $this->database->Query("SELECT * FROM navigator_publics ORDER BY ordernum");
        Console::WriteLine("completed!");
    }

    public function LoadRoomModels() {
        if (isset($this->roommodels)) {
            unset($this->roommodels);
        }
        Console::Write("Loading Room Models...");
        $this->roommodels = $this->database->Query("SELECT * FROM room_models");
        Console::WriteLine("completed!");
    }

    public function LoadRoomAds() {
        if (isset($this->roomads)) {
            unset($this->roomads);
        }
        Console::Write("Loading Room Adverts...");
        $this->roomads = $this->database->Query("SELECT * FROM room_ads");
        Console::WriteLine("completed!");
    }

    public function LoadBots() {
        if (isset($this->bots) && isset($this->botsspeech) && isset($this->botsresponses)) {
            unset($this->bots, $this->botsspeech, $this->botsresponses);
        }
        Console::Write("Loading Bots...");
        $this->bots = $this->database->Query("SELECT * FROM bots");
        $this->botsspeech = $this->database->Query("SELECT * FROM bots_speech");
        $this->botsresponses = $this->database->Query("SELECT * FROM bots_responses");
        Console::WriteLine("completed!");
    }

    public function LoadAchievements() {
        if (isset($this->achievements)) {
            unset($this->achievements);
        }
        Console::Write("Loading Achievements...");
        $this->achievements = $this->database->Query("SELECT * FROM achievements");
        Console::WriteLine("completed!");
    }

    public function LoadChatFilter() {
        if (isset($this->chatfilter)) {
            unset($this->chatfilter);
        }
        Console::Write("Loading Chat Filter...");
        $this->chatfilter = $this->database->Query("SELECT * FROM wordfilter");
        Console::WriteLine("completed!");
    }

    public function LoadQuests() {
        if (isset($this->quests)) {
            unset($this->quests);
        }
        Console::Write("Loading Quests...");
        $this->quests = $this->database->Query("SELECT * FROM quests");
        Console::WriteLine("completed!");
    }

    public function LoadGroups() {
        if (isset($this->groups) && isset($this->grouprequests) && isset($this->groupmemberships)) {
            unset($this->groups, $this->grouprequests, $this->groupmemberships);
        }
        Console::Write("Loading Groups...");
        $this->groups = $this->database->Query("SELECT * FROM groups");
        $this->grouprequests = $this->database->Query("SELECT * FROM group_requests");
        $this->groupmemberships = $this->database->Query("SELECT * FROM group_memberships");
        Console::WriteLine("completed!");
    }

    public function CleanDatabase() {
        Console::Write("Cleaning Database...");
        $this->database->Exec("UPDATE users SET online = '0'");
        $this->database->Exec("UPDATE rooms SET users_now = 0");
        $this->database->Exec("UPDATE server_status SET users_online = 0, rooms_loaded = 0");
        Console::WriteLine("completed!");
    }

}
