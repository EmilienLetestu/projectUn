<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 17:30
 */
namespace tests\Entity;
use App\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StoryTest extends TestCase
{
    public function testStory()
    {
        //generate object
        $story = new Story();

        //crate test data
        $plot ="Adhibens urbium parcens vexabat latera haec latera omnibus nec primatibus primatibus urbium parcens vexabat nec cuncta post 
        parcens onerosus modum disseminata post adhibens iam plebeiis nullum cuncta haec parcens honoratis disseminata urbium modum 
        parcens post bonis vexabat post omnibus parcens bonis post nec orientis primatibus disseminata urbium post omnibus modum.Adhibens 
        urbium parcens vexabat latera haec latera omnibus nec primatibus primatibus urbium parcens vexabat nec cuncta post parcens onerosus 
        modum disseminata post adhibens iam plebeiis nullum cuncta haec parcens honoratis disseminata urbium modum parcens post bonis 
        vexabat post omnibus parcens bonis post nec orientis primatibus disseminata urbium post omnibus modum.";

        $abstract = "Adhibens urbium parcens vexabat latera haec latera omnibus nec primatibus primatibus urbium parcens vexabat nec cuncta post
        parcens onerosus modum disseminata post adhibens iam plebeiis nullum cuncta haec parcens honoratis disseminata 
        urbium modum parcens post bonis vexabat post omnibus parcens bonis post nec orientis primatibus disseminata urbium post omnibus modum.";

        $title   = 'lorem ipsum';
        $email   = 'eletestu@gmail.com';
        $place   = 'Paris';
        $phone   = '0677887489';
        $country = 'jp';
        $year    = '2015';

        $today = new \DateTime(date('Y-m-d'));

        //hydrate with test data
        $story->setAbstract($abstract);
        $story->setTitle($title);
        $story->setCreatedOn($format=('Y-m-d'));
        $story->setPlot($plot);
        $story->setContactEmail($email);
        $story->setContactPlace($place);
        $story->setContactPhone($phone);
        $story->setCountry($country);
        $story->setYear($year);

        //test
        static::assertEquals($abstract, $story->getAbstract());
        static::assertEquals($title,    $story->getTitle());
        static::assertEquals($today,    $story->getCreatedOn());
        static::assertEquals($plot,     $story->getPLot());
        static::assertEquals($email,    $story->getContactEmail());
        static::assertEquals($place,    $story->getContactPLace());
        static::assertEquals($phone,    $story->getContactPhone());
        static::assertEquals($country,  $story->getCountry());
        static::assertEquals($year,     $story->getYear());
    }
}