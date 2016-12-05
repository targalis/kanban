<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="fk_comment_card_idx", columns={"card"})})
 * @ORM\Entity
 */
class Comment
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
     * @var \Entity\Card
     *
     * @ORM\ManyToOne(targetEntity="Entity\Card")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="card", referencedColumnName="id")
     * })
     */
    private $card;



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
     * Set card
     *
     * @param \Entity\Card $card
     *
     * @return Comment
     */
    public function setCard(\Entity\Card $card = null)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return \Entity\Card
     */
    public function getCard()
    {
        return $this->card;
    }
}
