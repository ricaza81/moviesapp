<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @UniqueEntity(fields="title", message="Title is already taken.")
 * @UniqueEntity(fields="yearPublication", message="Year is already taken.")
 * @ORM\Entity(repositoryClass="App\Repository\FilmRepository")
 */
class Film
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="year_publication", type="string", length=255, unique=true)
     */
    private $yearPublication;
	
	/**
     * @ORM\ManyToMany(targetEntity="Persons")
     * @ORM\JoinTable(name="film_persons")
     */
    Private $persons;
  
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set yearPublication
     *
     * @param string $yearPublication
     *
     * @return Film
     */
    public function setYearPublication($yearPublication)
    {
        $this->yearPublication = $yearPublication;

        return $this;
    }

    /**
     * Get yearPublication
     *
     * @return string
     */
    public function getYearPublication()
    {
        return $this->yearPublication;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add person
     *
     * @param \MoviesApp\MoviesBundle\Entity\Persons $person
     *
     * @return Film
     */
    public function addPerson(\MoviesApp\MoviesBundle\Entity\Persons $person)
    {
        $this->persons[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \MoviesApp\MoviesBundle\Entity\Persons $person
     */
    public function removePerson(\MoviesApp\MoviesBundle\Entity\Persons $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
        ? null
        : $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
        return null === $this->path
        ? null
        : $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/films';
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
            );
        
        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();
        
        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
