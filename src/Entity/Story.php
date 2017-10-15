<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 14:59
 */
namespace  App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Story
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="story")
 * @ORM\Entity(repositoryClass="App\Repository\StoryRepository")
 */
class Story
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="stories")
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id")
     */
    private $topic;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Patronage", inversedBy="stories")
     * @ORM\JoinColumn(name="patronage_id", referencedColumnName="id")
     */
    private $patronage;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Url", mappedBy="story")
     */
    private $urls;

    /**
     * @var
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $abstract;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $plot;

    /**
     * @var
     * @ORM\Column(type="string", length=255)
     */
    private $contactEmail;

    /**
     * @var
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPlace;

    /**
     * @var
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPhone;

    /**
     * @var
     * @ORM\Column(type="date")
     */
    private $createdOn;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $country;

    /**
     * @var
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $year = null;


    /**-------------------setters and getters-----------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
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
     */
    public function setPatronage($patronage)
    {
        $this->patronage = $patronage;

    }

    /**
     * @return mixed
     */
    public function getPatronage()
    {
        return $this->patronage;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }
    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param mixed $plot
     */
    public function setPlot($plot)
    {
        $this->plot = $plot;
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
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param mixed $contactPlace
     */
    public function setContactPlace($contactPlace)
    {
        $this->contactPlace = $contactPlace;
    }

    /**
     * @return mixed
     */
    public function getContactPlace()
    {
        return $this->contactPlace;
    }

    /**
     * @param mixed $contactPhone
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }


    /**
     * @param $format
     */
    public function setCreatedOn($format)
    {
        $this->createdOn = new \DateTime(date($format));
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**------------------------ relation management -------------------**/

    /**
     * Topic constructor.
     */
    public function __construct()
    {
        $this->urls = new ArrayCollection();
    }

    /**
     * @param Url $url
     * @return $this
     */
    public function addUrl(Url $url)
    {
        $this->urls[] = $url;

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

    /**
     * @param mixed $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }


}