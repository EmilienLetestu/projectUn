<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 11:55
 */

namespace App\Managers;


use App\Entity\Patronage;
use Doctrine\ORM\EntityManager;

class PatronageManager
{
    private $doctrine;

    /**
     * PatronageManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function fetchPatronageForAdmin()
    {
        $repository = $this->doctrine->getRepository(Patronage::class);

        return $repository->findAll();
    }

    /**
     * @param $patronage
     */
    public function createPatronage($patronage)
    {
        $this->doctrine->getRepository(Patronage::class);
        $this->doctrine->persist($patronage);
        $this->doctrine->flush();
    }
}