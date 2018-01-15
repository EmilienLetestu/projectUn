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

    /**
     * AddTermHandler constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param FormInterface $form
     * @param Term $term
     * @return bool
     */
    public function handle(FormInterface $form, Term $term): bool
    {
        if($form->isSubmitted() && $form->isValid()){

            $term->setArticle($form->get('article')->getData());
            $term->setTitle($form->get('title')->getData());
            $term->setStatus($form->get('status')->getData());

            !$term->getCreatedOn() ?
                $term->setCreatedOn('Y-m-d') :
                $term->getCreatedOn()
            ;

            $term->getStatus() === 'published' ?
                $term->setPublishedOn('Y-m-d') :
                null
            ;

            $this->doctrine->persist($term);
            $this->doctrine->flush();

            return true;
        }

        return false;
    }
}
