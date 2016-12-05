<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checklist
 *
 * @ORM\Table(name="checklist", indexes={@ORM\Index(name="checklist_card", columns={"card"})})
 * @ORM\Entity
 */
class Checklist
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
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

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
     * @ORM\OneToMany(targetEntity="Task", mappedBy="checklist")
     */
    private $task;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->task = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Checklist
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
     * Set card
     *
     * @param \Entity\Card $card
     *
     * @return Checklist
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

    /**
     * Add task
     *
     * @param \Entity\Task $task
     *
     * @return Checklist
     */
    public function addTask(\Entity\Task $task)
    {
        $this->task[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \Entity\Task $task
     */
    public function removeTask(\Entity\Task $task)
    {
        $this->task->removeElement($task);
    }

    /**
     * Get task
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTask()
    {
        return $this->task;
    }
}
