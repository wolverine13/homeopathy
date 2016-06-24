<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 12.06.16
 * Time: 09:20
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Homeopathy
 * @ORM\Entity
 * @ORM\Table(name="homeopathy")
 */
class Homeopathy
{
    /**
     *  @ORM\Column(type="integer")
     *  @ORM\Id
     *  @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string",length=30,nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(type="integer",length=4,nullable=false)
     */
    private $ch;
    /**
     * @ORM\Column(type="integer",length=3,nullable=false)
     */
    private $qty;
    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="homeopathies")
     * @ORM\JoinColumn(name="usr_id",referencedColumnName="id")
     */
    private $usr_id;


    public function __construct($user_id)
    {
       $this->usr_id = $user_id;
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
     * Set name
     *
     * @param string $name
     *
     * @return Homeopathy
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set ch
     *
     * @param integer $ch
     *
     * @return Homeopathy
     */
    public function setCh($ch)
    {
        $this->ch = $ch;

        return $this;
    }

    /**
     * Get ch
     *
     * @return integer
     */
    public function getCh()
    {
        return $this->ch;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Homeopathy
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set usrId
     *
     * @param \AppBundle\Entity\User $usrId
     *
     * @return Homeopathy
     */
    public function setUsrId(\AppBundle\Entity\User $usrId = null)
    {
        $this->usr_id = $usrId;

        return $this;
    }

    /**
     * Get usrId
     *
     * @return \AppBundle\Entity\User
     */
    public function getUsrId()
    {
        return $this->usr_id;
    }
}
