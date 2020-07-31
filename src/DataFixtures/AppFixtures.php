<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i=0;$i<=30;$i++)
        {
            $ad = new Ad();
            $slugify = new Slugify();

            $titre = $faker->streetName();
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';

            $ad->setTitle($titre);
            $ad->setContent($content);
            $ad->setSlug($slugify->slugify($titre));
            $ad->setCoverImage($faker->imageUrl(200,100));
            $ad->setIntroduction($faker->realText(50));
            $ad->setRooms(mt_rand(2,8));
            $ad->setPrice(mt_rand(20,200));
            $manager->persist($ad);

            for ($j=0;$j<=mt_rand(2,5);$j++)
            {
                $image = new Image();
                $image->setUrl($faker->imageUrl(200,100));
                $image->setCaption($faker->sentence);
                $image->setAd($ad);
                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}