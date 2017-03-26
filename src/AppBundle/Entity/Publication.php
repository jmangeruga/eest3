<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="publication")
 */
class Publication {

	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/** @ORM\Column(type="string", length=100) */
	private $title;

	/** @ORM\Column(type="text") */
	private $summary;

	/** @ORM\Column(type="text") */
	private $content;

	/** 
	 * @ORM\ManyToOne(targetEntity="User") 
	 * @ORM\JoinColumn(name="author", referencedColumnName="dni", nullable=false)
	 */
	private $author;

	/** 
	 * @ORM\ManyToOne(targetEntity="Section") 
	 * @ORM\JoinColumn(name="section", referencedColumnName="id", nullable=false)
	 */
	private $section;

	/** @ORM\Column(type="string", length=15) */
	private $type;

	/** @ORM\Column(type="datetime") */
	private $limitDate;

	/** @ORM\OneToMany(targetEntity="Media", mappedBy="publication") */
	private $mediaResources;

	/**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaResources = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Publication
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
     * Set summary
     *
     * @param string $summary
     *
     * @return Publication
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Publication
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Publication
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set limitDate
     *
     * @param \DateTime $limitDate
     *
     * @return Publication
     */
    public function setLimitDate($limitDate)
    {
        $this->limitDate = $limitDate;

        return $this;
    }

    /**
     * Get limitDate
     *
     * @return \DateTime
     */
    public function getLimitDate()
    {
        return $this->limitDate;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Publication
     */
    public function setAuthor(\AppBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Publication
     */
    public function setSection(\AppBundle\Entity\Section $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Add mediaResource
     *
     * @param \AppBundle\Entity\Media $mediaResource
     *
     * @return Publication
     */
    public function addMediaResource(\AppBundle\Entity\Media $mediaResource)
    {
        $this->mediaResources[] = $mediaResource;

        return $this;
    }

    /**
     * Remove mediaResource
     *
     * @param \AppBundle\Entity\Media $mediaResource
     */
    public function removeMediaResource(\AppBundle\Entity\Media $mediaResource)
    {
        $this->mediaResources->removeElement($mediaResource);
    }

    /**
     * Get mediaResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaResources()
    {
        return $this->mediaResources;
    }
}
