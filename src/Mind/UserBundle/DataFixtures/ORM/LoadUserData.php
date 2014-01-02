<?php 

namespace Mind\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        //User
        
        $infos = array(
            'shonen.shojo@midosphere.com'    => 'Hipopeur',
            'diallo@midosphere.com'          => 'Diallo',
            'Jean@midosphere.com'            => 'Jean'
        );
        
        foreach ($infos as $key => $valeur){
        
            $userAdmin = new \Mind\UserBundle\Entity\User();
            $userAdmin->setUsername($valeur);
            $userAdmin->setDateNaissance(new \DateTime());
            $userAdmin->setEmail($key);
            $userAdmin->setPays('FR');
            $userAdmin->setSexe(1);
            $userAdmin->setCdtGenerales(1);
            $userAdmin->setEnabled(1);
            $userAdmin->setPassword('1234');
            
            $manager->persist($userAdmin);
        }
        
        $manager->flush();
        
        
        
    }
}

?>