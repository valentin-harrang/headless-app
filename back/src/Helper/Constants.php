<?php

namespace App\Helper;

class Constants
{
    public const NEWS_FEED_DEFAULT_LIMIT             = 25;
    public const NEWS_FEEDS                          = [
        [
            'name'       => 'L\'équipe',
            'categories' => self::LEQUIPE_RSS_FEED_CATEGORIES,
        ],
    ];
    public const LEQUIPE_SOCCER_RSS_FEED_URL         = 'https://www6.lequipe.fr/rss/actu_rss_Football.xml';
    public const LEQUIPE_SOCCER_MERCATO_RSS_FEED_URL = 'https://www6.lequipe.fr/rss/actu_rss_Transferts.xml';
    public const LEQUIPE_TENNIS_RSS_FEED_URL         = 'https://www6.lequipe.fr/rss/actu_rss_Tennis.xml';
    public const LEQUIPE_RUGBY_RSS_FEED_URL          = 'https://www6.lequipe.fr/rss/actu_rss_Rugby.xml';
    public const LEQUIPE_CYCLING_RSS_FEED_URL        = 'https://www6.lequipe.fr/rss/actu_rss_Cyclisme.xml';
    public const LEQUIPE_BASKETBALL_RSS_FEED_URL     = 'https://www6.lequipe.fr/rss/actu_rss_Basket.xml';
    public const LEQUIPE_NBA_RSS_FEED_URL            = 'https://www6.lequipe.fr/rss/actu_rss_NBA.xml';
    public const LEQUIPE_AUTO_SPORTS_RSS_FEED_URL    = 'https://www6.lequipe.fr/rss/actu_rss_Auto-Moto.xml';
    public const LEQUIPE_FORMULE_1_RSS_FEED_URL      = 'https://www6.lequipe.fr/rss/actu_rss_F1.xml';
    public const LEQUIPE_RALLYE_RSS_FEED_URL         = 'https://www6.lequipe.fr/rss/actu_rss_Rallye.xml';
    public const LEQUIPE_MOTORBIKE_RSS_FEED_URL      = 'https://www6.lequipe.fr/rss/actu_rss_Moto.xml';
    public const LEQUIPE_HANDBALL_RSS_FEED_URL       = 'https://www6.lequipe.fr/rss/actu_rss_Hand.xml';
    public const LEQUIPE_VOLLEYBALL_RSS_FEED_URL     = 'https://www6.lequipe.fr/rss/actu_rss_Volley.xml';
    public const LEQUIPE_SKI_RSS_FEED_URL            = 'https://www6.lequipe.fr/rss/actu_rss_Ski.xml';
    public const LEQUIPE_GOLF_RSS_FEED_URL           = 'https://www6.lequipe.fr/rss/actu_rss_Golf.xml';
    public const LEQUIPE_ATHLETICS_RSS_FEED_URL      = 'https://www6.lequipe.fr/rss/actu_rss_Athletisme.xml';
    public const LEQUIPE_SWIMMING_RSS_FEED_URL       = 'https://www6.lequipe.fr/rss/actu_rss_Natation.xml';
    public const LEQUIPE_SAIL_RSS_FEED_URL           = 'https://www6.lequipe.fr/rss/actu_rss_Voile.xml';
    public const LEQUIPE_JUDO_RSS_FEED_URL           = 'https://www6.lequipe.fr/rss/actu_rss_Judo.xml';
    public const LEQUIPE_FENCING_RSS_FEED_URL        = 'https://www6.lequipe.fr/rss/actu_rss_Escrime.xml';
    public const LEQUIPE_ESPORT_RSS_FEED_URL         = 'https://www6.lequipe.fr/rss/actu_rss_esport.xml';
    public const LEQUIPE_RSS_FEED_CATEGORIES         = [
        'soccer'         => [
            'url'  => self::LEQUIPE_SOCCER_RSS_FEED_URL,
            'name' => 'Football',
        ],
        'soccer_mercato' => [
            'url'  => self::LEQUIPE_SOCCER_MERCATO_RSS_FEED_URL,
            'name' => 'Football (mercato)',
        ],
        'tennis'         => [
            'url'  => self::LEQUIPE_TENNIS_RSS_FEED_URL,
            'name' => 'Tennis',
        ],
        'rugby'          => [
            'url'  => self::LEQUIPE_RUGBY_RSS_FEED_URL,
            'name' => 'Rugby',
        ],
        'cycling'        => [
            'url'  => self::LEQUIPE_CYCLING_RSS_FEED_URL,
            'name' => 'Cyclisme',
        ],
        'basketball'     => [
            'url'  => self::LEQUIPE_BASKETBALL_RSS_FEED_URL,
            'name' => 'Basket',
        ],
        'nba'            => [
            'url'  => self::LEQUIPE_NBA_RSS_FEED_URL,
            'name' => 'NBA',
        ],
        'auto_sports'    => [
            'url'  => self::LEQUIPE_AUTO_SPORTS_RSS_FEED_URL,
            'name' => 'Sports auto',
        ],
        'formule_1'      => [
            'url'  => self::LEQUIPE_FORMULE_1_RSS_FEED_URL,
            'name' => 'Formule 1',
        ],
        'rallye'         => [
            'url'  => self::LEQUIPE_RALLYE_RSS_FEED_URL,
            'name' => 'Rallye',
        ],
        'motorbike'      => [
            'url'  => self::LEQUIPE_MOTORBIKE_RSS_FEED_URL,
            'name' => 'Moto',
        ],
        'handball'       => [
            'url'  => self::LEQUIPE_HANDBALL_RSS_FEED_URL,
            'name' => 'Handball',
        ],
        'volleyball'     => [
            'url'  => self::LEQUIPE_VOLLEYBALL_RSS_FEED_URL,
            'name' => 'Volley',
        ],
        'ski'            => [
            'url'  => self::LEQUIPE_SKI_RSS_FEED_URL,
            'name' => 'Ski',
        ],
        'golf'           => [
            'url'  => self::LEQUIPE_GOLF_RSS_FEED_URL,
            'name' => 'Golf',
        ],
        'athletics'      => [
            'url'  => self::LEQUIPE_ATHLETICS_RSS_FEED_URL,
            'name' => 'Athlétisme',
        ],
        'swimming'       => [
            'url'  => self::LEQUIPE_SWIMMING_RSS_FEED_URL,
            'name' => 'Natation',
        ],
        'sail'           => [
            'url'  => self::LEQUIPE_SAIL_RSS_FEED_URL,
            'name' => 'Voile',
        ],
        'judo'           => [
            'url'  => self::LEQUIPE_JUDO_RSS_FEED_URL,
            'name' => 'Judo',
        ],
        'fencing'        => [
            'url'  => self::LEQUIPE_FENCING_RSS_FEED_URL,
            'name' => 'Escrime',
        ],
        'esport'         => [
            'url'  => self::LEQUIPE_ESPORT_RSS_FEED_URL,
            'name' => 'Esport',
        ],
    ];
    // /!\ Only for demo because it's unsecure
    public const USER_FIXTURES                      = [
        [
            'username' => 'contact@valentin-harrang.fr',
            'email'    => 'contact@valentin-harrang.fr',
            'name'     => 'Valentin',
            'password' => '123456!',
        ],
    ];
}
