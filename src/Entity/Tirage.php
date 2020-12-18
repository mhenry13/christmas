<?php

class Tirage
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    public function __construct()
    {
        $this->created_at = new \DateTime();
    }


}