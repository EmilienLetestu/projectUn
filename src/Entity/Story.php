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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stories")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * @ORM\Column(type="string", length=100)
     */
    private $contactEmail;

    /**
     * @var
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contactPlace = null;

    /**
     * @var
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $contactPhone = null;

    /**
     * @var
     * @ORM\Column(type="date")
     */
    private $createdOn;

    /**
     * @var
     * @ORM\Column(type="text", length=5)
     */
    private $country;

    /**
     * @var
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $year = null;

    /**
     * @var
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $investor = null;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Url",mappedBy="story")
     */
    private $urls;

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
}