<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SujetSuivis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\SujetSuivisRepository")
 */
class SujetSuivis
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
