<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 15:02
 */

namespace App\Handler;

use App\Entity\Patronage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Handler\Inter\EditPatronageHandlerInterface;


class EditPatronageHandler implements EditPatronageHandlerInterface
{
    private $doctrine;

    /**
     * EditPatronageHandler constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface  $doctrine)
    {
        $this->doctrine    = $doctrine;
    }

    public function handle(FormInterface $form, Patronage $patronage): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('patronageId')->getData() !== null)
            {
                $repository = $this->doctrine->getRepository(Patronage::class);
                $patronage = $repository->find($form->get('patronageId')->getData());
            }

            $patronage->setOrganization($form->get('organization')->getData());
            $this->doctrine->persist($patronage);
            $this->doctrine->flush();

            return true;
        }
        return false;
    }
}