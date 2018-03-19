<?php

return [

    'app_title' => 'Pew-Pew-Pew',

    'env' => 'dev',

    # closures will receive the injection container as argument
    'currentUser' => function ($c) {
        if (isset($c['session']['user'])) {
            return \app\models\User::findOneById($c['session']['user.id']);
        }

        return false;
    },

    'debug' => true,

    'blacklist' => [
        'danielstjules/stringy' => true,
        'filp/whoops' => true,
        'ifcanduela/abbrev' => true,
        'ifcanduela/db' => true,
        'ifcanduela/pew' => true,
        'monolog/monolog' => true,
        'nikic/fast-route' => true,
        'paragonie/random_compat' => true,
        'pimple/pimple' => true,
        'psr/container' => true,
        'psr/log' => true,
        'symfony/http-foundation' => true,
        'symfony/polyfill-mbstring' => true,
        'symfony/polyfill-php70' => true,
    ],

    'packages' => function ($c) {
        $blacklist = $c['blacklist'];

        $composer_lock = root("composer.lock");
        $json = json_decode(file_get_contents($composer_lock));
        
        $packages = array_map(function ($package) use ($blacklist) {
            $package->protected = isset($blacklist[$package->name]);

            return $package;
        }, $json->packages);

        return $packages;
    },
];
