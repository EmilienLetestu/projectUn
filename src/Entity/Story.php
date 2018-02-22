<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 14:59
 */
namespace  App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Intl\Intl;


/**
 * Class Story
 * @package App\Entity
 */
class Story implements \Serializable
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $topic;

    /**
     * @var
     */
    private $patronage;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $abstract;

    /**
     * @var
     */
    private $plot;

    /**
     * @var
     */
    private $contactEmail;

    /**
     * @var
     */
    private $contactPlace = null;

    /**
     * @var
     */
    private $contactPhone = null;

    /**
     * @var
     */
    private $createdOn;

    /**
     * @var
     */
    private $country = null;

    /**
     * @var
     */
    private $worldArea;

    /**
     * @var
     */
    private $year = null;

    /**
     * @var
     */
    private $investor = null;


    /**
     * @var
     */
    private $urls;

    /**
     * @var
     */
    private $validated = false;

    /**-------------------setters and getters-----------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $topic
     * @return mixed
     */
    public function setTopic($topic)
    {
      return  $this->topic = $topic;
    }

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param $patronage
     * @return mixed
     */
    public function setPatronage($patronage)
    {
      return $this->patronage = $patronage;

    }

    /**
     * @return mixed
     */
    public function getPatronage()
    {
        return $this->patronage;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function setUser($user)
    {
      return  $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title)
    {
        return $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $abstract
     * @return mixed
     */
    public function setAbstract($abstract)
    {
       return $this->abstract = $abstract;
    }
    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param $plot
     * @return mixed
     */
    public function setPlot($plot)
    {
       return $this->plot = $plot;
    }

    /**
     * @return mixed
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * @param $contactEmail
     * @return mixed
     */
    public function setContactEmail($contactEmail)
    {
       return $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param $contactPlace
     * @return mixed
     */
    public function setContactPlace($contactPlace)
    {
       return $this->contactPlace = $contactPlace;
    }

    /**
     * @return mixed
     */
    public function getContactPlace()
    {
        return $this->contactPlace;
    }

    /**
     * @param $contactPhone
     * @return mixed
     */
    public function setContactPhone($contactPhone)
    {
      return  $this->contactPhone = $contactPhone;
    }

    /**
     * @return null
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }


    /**
     * @param $format
     * @return \DateTime
     */
    public function setCreatedOn($format)
    {
      return $this->createdOn = new \DateTime(date($format));
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param $country
     * @return mixed
     */
    public function setCountry($country)
    {
        return $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $worldArea
     * @return mixed
     */
    public function setWorldArea($worldArea)
    {
        return $this->worldArea = $worldArea;
    }

    /**
     * @return mixed
     */
    public function getWorldArea()
    {
        return $this->worldArea;
    }

    /**
     * @param $year
     * @return mixed
     */
    public function setYear($year)
    {
       return $this->year = $year;
    }

    /**
     * @return null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param $investor
     * @return mixed
     */
    public function setInvestor($investor)
    {
        return $this->investor = $investor;
    }

    /**
     * @return null
     */
    public function getInvestor()
    {
        return $this->investor;
    }

    /**
     * @param $validated
     * @return mixed
     */
    public function setValidated($validated)
    {
        return $this->validated = $validated;
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**------------------------ relation management -------------------**/

    /**
     * Story constructor.
     */
    public function __construct()
    {
        $this->urls =  new  ArrayCollection();
    }

    /**
     * @param Url $url
     * @return $this
     */
    public function addUrl(Url $url)
    {
        $this->urls[] = $url;

        $url->setStory($this);

        return $this;
    }

    /**
     * @param Url $url
     */
    public function removeUrl(Url $url)
    {
        $this->urls->removeElement($url);
    }

    /**
     * @return ArrayCollection
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**---------------------- serialize------------------------*/

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getAbstract(),
            $this->getPlot(),
            $this->getContactEmail(),
            $this->getCountryName(),
            $this->getWorldArea(),
            $this->getCreatedOn(),
            $this->getInvestor(),
            $this->getAuthor(),
            $this->getContactPhone(),
            $this->getContactPlace()
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->abstract,
            $this->plot,
            $this->contactEmail,
            $this->countryName,
            $this->worldArea,
            $this->createdOn,
            $this->investor,
            $this->author,
            $this->contactPhone,
            $this->contactPlace
            ) = unserialize($serialized)
        ;
    }

    /**---------------------- view methods (admin)------------------------*/

    public function getTopicType()
    {
        return $this->getTopic()->getType();
    }

    public function getAuthor()
    {
        return $this->getUser()->getFullName();
    }

    public function getPatronageBy()
    {
        return $this->getPatronage()->getOrganization();
    }

    public function getCountryName()
    {
        return  Intl::getRegionBundle()->getCountryName($this->getCountry());
    }

    public function getWorldAreaName()
    {
        $worldArea = [
            '1' =>  'Africa',
            '2' =>  'Asia',
            '3' =>  'Europe',
            '4' =>  'North America',
            '5' =>  'South America',
            '6' =>  'Oceania'
        ];

        return $worldArea[$this->getWorldArea()];
    }
}

