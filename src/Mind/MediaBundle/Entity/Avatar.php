<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Avatar
 *
 * @ORM\Table(name="avatar")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\AvatarRepository")
 * @Gedmo\Uploadable(allowOverwrite=true, filenameGenerator="SHA1", path="../web/uploads/user/avatars")
 */
class Avatar
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
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;
    
    /**
     * @ORM\Column(name="mime_type", type="string", nullable=true)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;
    
    /**
     * @ORM\Column(name="size", type="decimal", nullable=true)
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="id_user", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * 
     */
    private $idUser;

    /**
     * @Assert\Image(maxSize="6000000000",
     *     mimeTypesMessage = "Ce format d'image n'est pas autorisé.",
     *     uploadIniSizeErrorMessage = "Le fichier dépasse la taille définit par upload_max_filesize dans PHP.ini.",
     *     uploadFormSizeErrorMessage = "Le fichier dépasse la taille définit dans le formulaire.",
     *     uploadErrorMessage = "Pour une raison inconnue le fichier n'a pu être télécharger.",
     *     maxSizeMessage = "Le fichier est trop volumineux. La taille limite est de 1024MO(1 giga)."
     * )
     */
    public $file;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFile(){
        return $this->file;
    }
    
    
    /**
     * Set path
     *
     * @param string $path
     * @return Avatar
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
     * @return Avatar
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
     * @return Avatar
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
     * Set idUser
     *
     * @param integer $idUser
     * @return Avatar
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
