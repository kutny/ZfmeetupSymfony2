<?php

namespace Stepiiik\ZfmeetupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Album
{
    const ENTITY_NAME = 'StepiiikZfmeetupBundle:Album';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=10)
     * @ORM\Column(type="string", length=10, nullable=false)
     * @var string $artist
     */
    private $artist;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=10)
     * @ORM\Column(type="string", length=10, nullable=false)
     * @var string $title
     */
    private $title;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer $id
     */
    private $id;

    /**
     * Set artist
     *
     * @param string $artist
     * @return Album
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    
        return $this;
    }

    /**
     * Get artist
     *
     * @return string 
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Album
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
