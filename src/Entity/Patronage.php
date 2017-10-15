<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 10:47
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Patronage
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="patronage")
 */
class Patronage
{
    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var
     * @ORM\Column(type="string", length=10)
     */
    private $organization;

    /**
     * @var
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $identity;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="patronage")
     */
    private $stories;

    /**------------------------ setters and getters -------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }


    /**
     * @param null $display
     * @return mixed
     */
    public function getOrganization($display = null)
    {
        if($display !== null)
        {
            $org = $this->organization;
            return $this->displayOrganizationName($org - 1);
        }
        return $this->organization;
    }


    /**
     * @param mixed $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**------------------------ relation management -------------------**/

    /**
     * Patronage constructor.
     */
    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }

    /**
     * @param Story $story
     * @return $this
     */
    public function addStory(Story $story)
    {
        $this->stories[] = $story;

        return $this;
    }

    /**
     * @param Story $story
     */
    public function removeStory(Story $story)
    {
        $this->stories->removeElement($story);
    }

    /**
     * @return ArrayCollection
     */
    public function getStories()
    {
        return $this->stories;
    }

    private function displayOrganizationName($organization)
    {
        $name = [
            'ong',
            'company',
            'town hall',
            'county',
            'association',
            'private investor',
        ];

        return $name[$organization];
    }

}

