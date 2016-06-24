<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 24.06.16
 * Time: 15:01
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Medicament
{
    /**
     *  @ORM\Column(type="integer")
     *  @ORM\Id
     *  @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     *  @ORM\Column(type="string", length=25)
     */
    private $name;
    private $medication; // how offeten the drug is taken

    public

}