<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="media")
 */
class Media {

	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

	/** 
     * @ORM\ManyToOne(targetEntity="Publication", inversedBy="mediaResources") 
     * @ORM\JoinColumn(name="publication", referencedColumnName="id", nullable=false)
     */
	private $publication;

	/** @ORM\Column(type="string",length=255) */
	private $url;

	/** @ORM\Column(type="string", length=15) */
	private $type;

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
     * Set url
     *
     * @param string $url
     *
     * @return Media
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Media
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
     * Set publication
     *
     * @param \AppBundle\Entity\Publication $publication
     *
     * @return Media
     */
    public function setPublication(\AppBundle\Entity\Publication $publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \AppBundle\Entity\Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
