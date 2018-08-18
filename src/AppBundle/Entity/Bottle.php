<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bottle
 *
 * @ORM\Table(name="bottle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BottleRepository")
 */
class Bottle
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
     * @var int
     *
     * @ORM\Column(name="thirtyMl", type="integer")
     */
    private $thirtyMl;

    /**
     * @var int
     *
     * @ORM\Column(name="fiftyMl", type="integer")
     */
    private $fiftyMl;

    /**
     * @var int
     *
     * @ORM\Column(name="hundredMl", type="integer")
     */
    private $hundredMl;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set thirtyMl.
     *
     * @param int $thirtyMl
     *
     * @return Bottle
     */
    public function setThirtyMl($thirtyMl)
    {
        $this->thirtyMl = $thirtyMl;

        return $this;
    }

    /**
     * Get thirtyMl.
     *
     * @return int
     */
    public function getThirtyMl()
    {
        return $this->thirtyMl;
    }

    /**
     * Set fiftyMl.
     *
     * @param int $fiftyMl
     *
     * @return Bottle
     */
    public function setFiftyMl($fiftyMl)
    {
        $this->fiftyMl = $fiftyMl;

        return $this;
    }

    /**
     * Get fiftyMl.
     *
     * @return int
     */
    public function getFiftyMl()
    {
        return $this->fiftyMl;
    }

    /**
     * Set hundredMl.
     *
     * @param int $hundredMl
     *
     * @return Bottle
     */
    public function setHundredMl($hundredMl)
    {
        $this->hundredMl = $hundredMl;

        return $this;
    }

    /**
     * Get hundredMl.
     *
     * @return int
     */
    public function getHundredMl()
    {
        return $this->hundredMl;
    }
}
