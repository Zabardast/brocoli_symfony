<?php
namespace App\EventListener;

use App\Entity\Billing;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserListener
{
    private $security;
    // private $repo;

    public function __construct(Security $security)
    {
        $this->security = $security;
        // $this->repo = $repo;
    }

    public function prePersist(EventLifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // timestampable method
        if(!method_exists($entity, 'getUser') || !method_exists($entity, 'setUser')) 
        {
        return;
        }
        //then the entity is billing before persiste
        $entity->setUser($this->security->getUser());
        $entityManager = $args->getObjectManager();
    }
}
?>