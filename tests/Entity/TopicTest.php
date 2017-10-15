<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 19:14
 */

namespace tests\Entity;

use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TopicTest extends TestCase
{
    public function testTopic()
    {
        $topic = new Topic();

        //hydrate with test data
        $topic->setType('Seas');
        static::assertEquals('Seas',$topic->getType());
    }
}