<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Stringy\Stringy;
use Doctrine\Common\Inflector\Inflector;
use Webmozart\Assert\Assert;

$broken = Stringy::create("Daniël from Curaçao: অসমীয়া লিপি বাংলা লিপি <== Nagari script");

echo $broken . PHP_EOL;
echo $broken->slugify() . PHP_EOL;

echo PHP_EOL;

echo "Plural of 'wolf': " . Inflector::pluralize("wolf") . PHP_EOL;
echo "Singular of 'people': " . Inflector::singularize("people") . PHP_EOL;

echo PHP_EOL;

$collection = new \pew\model\Collection(range(1, 10));
$collection = $collection->map(function ($number) {
    return $number + (mt_rand(0, 100) - 25) / 10000;
});

foreach ($collection as $i) {
    echo "{$i}  ===> " . M_PI * $i . PHP_EOL;
}

echo PHP_EOL;

$faker = \Faker\Factory::create();

echo $faker->name;
