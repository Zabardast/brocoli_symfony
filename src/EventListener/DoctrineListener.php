<?php
namespace App\EventListener;

use App\Entity\Billing;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineListener
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
        if(!method_exists($entity, 'getBillingNumber')) 
        {
        return;
        }
        //then the entity is billing before persiste

        $entityManager = $args->getObjectManager();
        $entityManager->getRepository(Billing::class)->findLastBillingId();
        // ... do something with the Product
        //get higest id from billing
    }
}
?>