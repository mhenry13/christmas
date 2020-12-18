<?php

/*
 * Specify the locking of a gift from an user with date
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class GiftBooking
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
     * @var Gift
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Gift")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gift;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $booked;

    public function __construct()
    {
        $this->booked = new \DateTime();
    }


}

