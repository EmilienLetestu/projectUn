<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 11/01/2018
 * Time: 23:45
 */

namespace App\Handler;


use App\Entity\Term;
use App\Handler\Inter\AddTermHandlerInterFace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class AddTermHandler implements AddTermHandlerInterFace
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function handle(FormInterface $form, Term $term): bool
    {
        if($form->isSubmitted() && $form->isValid()){


            $term->setArticle($form->get('article')->getData());
            $term->setTitle($form->get('title')->getData());

            $this->doctrine->persist($term);
            $this->doctrine->flush();

            return true;
        }

        return false;
    }
}