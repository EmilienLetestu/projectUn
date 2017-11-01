<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 01/11/2017
 * Time: 15:08
 */

namespace App\DataFixtures\ORM;

use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TopicFixtures extends Fixture
{
    /**
     * feed db with all needed data on first launch
     * create topics
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create topics
        $topicList = [
            'human settlements',
            'ocean',
            'water',
            'energy',
            'agriculture',
            'forests',
            'industries'
        ];
        foreach ($topicList as $key => $value)
        {
            $topic = new Topic();
            $topic->setType($value);
            $manager->persist($topic);
        }

        $manager->flush();
    }
}


