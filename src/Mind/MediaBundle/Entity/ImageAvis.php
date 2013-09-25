<?php

namespace Mind\MediaBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ImageAvis
 *
 * @ORM\Table(name="image_avis")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\ImageAvisRepository")
 * @Gedmo\Uploadable(allowOverwrite=true, callback="afterMoveImage", filenameGenerator="SHA1", path="../web/uploads/avis/images")
 */
class ImageAvis
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
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;
    
    /**
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;
    
    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;
    
    /**
     * @Assert\File(maxSize="6000000000", 
     *     mimeTypes={"jpg", "jpeg"},
     *     mimeTypesMessage = "Ce format d'image n'est pas autorisé.",
     *     uploadIniSizeErrorMessage = "Le fichier dépasse la taille définit par upload_max_filesize dans PHP.ini.",
     *     uploadFormSizeErrorMessage = "Le fichier dépasse la taille définit dans le formulaire.",
     *     uploadErrorMessage = "Pour une raison inconnue le fichier n'a pu être télécharger.",
     *     maxSizeMessage = "Le fichier est trop volumineux. La taille limite est de 1024MO(1 giga)."
     * )
     * 
     */
    public $file;

    //RELATION AVEC LES AUTRES ENTITES
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="avis", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\MediaBundle\Entity\ImageAvis")
     * @ORM\JoinColumn(name="avis", referencedColumnName="id")
     */
    private $avis;

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        unlink($this->getPath());
        
    }
    
    public function afterMoveImage(){
        
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
     * Set path
     *
     * @param string $path
     * @return ImageAvis
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return ImageAvis
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return ImageAvis
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set avis
     *
     * @param integer $avis
     * @return ImageAvis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return integer 
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ImageAvis
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
