<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 14/01/2018
 * Time: 12:42
 */

namespace App\Managers;


use App\Entity\Term;
use Doctrine\ORM\EntityManager;

class TermManager
{
    private $doctrine;

    /**
     * TermManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteTerm($id)
    {
        $repository = $this->doctrine->getRepository(Term::class);
        $term = $repository->find($id);

        $this->doctrine->remove($term);
        $this->doctrine->flush();

        return 'Legal notice article has been deleted';
    }

    /**
     * @param $id
     * @return string
     */
    public function validateTerm($id)
    {
        $repository = $this->doctrine->getRepository(Term::class);
        $term = $repository->find($id);

        $term->setStatus('published');
        $term->setPublishedOn('Y-m-d');

        $this->doctrine->flush();

        return 'Legal notice article published';
    }
}
