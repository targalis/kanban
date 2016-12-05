<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etiquette
 *
 * @ORM\Table(name="etiquette")
 * @ORM\Entity
 */
class Etiquette
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=45, nullable=false)
     */
    private $color;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Entity\Card", mappedBy="etiquette")
     */
    private $card;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->card = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Etiquette
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
     * Set color
     *
     * @param string $color
     *
     * @return Etiquette
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add card
     *
     * @param \Entity\Card $card
     *
     * @return Etiquette
     */
    public function addCard(\Entity\Card $card)
    {
        $this->card[] = $card;

        return $this;
    }

    /**
     * Remove card
     *
     * @param \Entity\Card $card
     */
    public function removeCard(\Entity\Card $card)
    {
        $this->card->removeElement($card);
    }

    /**
     * Get card
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCard()
    {
        return $this->card;
    }
}
