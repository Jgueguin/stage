<?php

namespace STAGE\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectEntity
 *
 * @ORM\Table(name="project_entity")
 * @ORM\Entity(repositoryClass="STAGE\IndexBundle\Repository\ProjectEntityRepository")
 */
class ProjectEntity
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
     * @ORM\Column(name="proj_title", type="string", length=100)
     */
    private $projTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="proj_descr", type="text")
     */
    private $projDescr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proj_date", type="date", nullable=true)
     */
    private $projDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proj_datemod", type="date", nullable=true)
     */
    private $projDatemod;


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
     * Set projTitle
     *
     * @param string $projTitle
     *
     * @return ProjectEntity
     */
    public function setprojTitle($projTitle)
    {
        $this->projTitle = $projTitle;

        return $this;
    }

    /**
     * Get projTitle
     *
     * @return string
     */
    public function getProjTitle()
    {
        return $this->projTitle;
    }

    /**
     * Set projDescr
     *
     * @param string $projDescr
     *
     * @return ProjectEntity
     */
    public function setprojDescr($projDescr)
    {
        $this->projDescr = $projDescr;

        return $this;
    }

    /**
     * Get projDescr
     *
     * @return string
     */
    public function getProjDescr()
    {
        return $this->projDescr;
    }

    /**
     * Set projDate
     *
     * @param \DateTime $projDate
     *
     * @return ProjectEntity
     */
    public function setprojDate($projDate)
    {
        $this->projDate = $projDate;

        return $this;
    }

    /**
     * Get projDate
     *
     * @return \DateTime
     */
    public function getProjDate()
    {
        return $this->projDate;
    }

    /**
     * Set projDatemod
     *
     * @param \DateTime $projDatemod
     *
     * @return ProjectEntity
     */
    public function setprojDatemod($projDatemod)
    {
        $this->projDatemod = $projDatemod;

        return $this;
    }

    /**
     * Get projDatemod
     *
     * @return \DateTime
     */
    public function getProjDatemod()
    {
        return $this->projDatemod;
    }




}
