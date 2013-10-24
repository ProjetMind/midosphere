<?php 

namespace Mind\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEntityData implements FixtureInterface
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        $users = $manager->getRepository("MindUserBundle:User")->findAll();
        
        foreach ($users as $user){
        
            $avis = new \Mind\SiteBundle\Entity\Avis();
            
            
            $manager->persist($avis);
        }
        
        $manager->flush();
        
        
        
    }
}

?>