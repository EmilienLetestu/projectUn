<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 18/01/2018
 * Time: 15:39
 */

namespace tests\Entity;

use App\Entity\Term;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TermTest extends TestCase
{
    public function testTerm()
    {
        $term    = new Term();

        $title       = 'lorem ipsum';
        $status      = 'published';
        $format      = ('Y-m-d');
        $article     = 'Adhibens urbium parcens vexabat latera haec latera omnibus nec primatibus primatibus urbium parcens vexabat nec cuncta post 
        parcens onerosus modum disseminata post adhibens iam plebeiis nullum cuncta haec parcens honoratis disseminata urbium modum 
        parcens post bonis vexabat post omnibus parcens bonis post nec orientis primatibus disseminata urbium post omnibus modum.Adhibens 
        urbium parcens vexabat latera haec latera omnibus nec primatibus primatibus urbium parcens vexabat nec cuncta post parcens onerosus 
        modum disseminata post adhibens iam plebeiis nullum cuncta haec parcens honoratis disseminata urbium modum parcens post bonis 
        vexabat post omnibus parcens bonis post nec orientis primatibus disseminata urbium post omnibus modum.';

        $today       = new \DateTime(date('Y-m-d'));

        $term->setTitle($title);
        $term->setStatus($status);
        $term->setPublishedOn($format);
        $term->setCreatedOn($format);
        $term->setArticle($article);

        //test
        static::assertEquals($title, $term->getTitle());
        static::assertEquals($status, $term->getStatus());
        static::assertEquals($today, $term->getPublishedOn());
        static::assertEquals($today, $term->getCreatedOn());
        static::assertEquals($article, $term->getArticle());

    }
}