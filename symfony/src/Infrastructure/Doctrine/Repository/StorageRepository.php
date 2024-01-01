<?php

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Stockage\Entity\Storage;
use Domain\Stockage\Gateway\StorageGateway;
use Infrastructure\Doctrine\Entity\StorageDoctrine;
use Symfony\Component\HttpKernel\HttpCache\Store;

/**
 * @extends ServiceEntityRepository<Storage>
 *
 * @method Storage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Storage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Storage[]    findAll()
 * @method Storage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageRepository extends ServiceEntityRepository implements StorageGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDoctrine::class);
    }

    public function create(Storage $storage): Storage
    {
        $storageDoctrine = new StorageDoctrine();

        $storageDoctrine->setName($storage->getName());
        $storageDoctrine->setCity($storage->getCity());

        $this->_em->persist($storageDoctrine);
        $this->_em->flush();

        return new Storage(
            $storageDoctrine->getName(),
            $storageDoctrine->getCity(),
            $storageDoctrine->getId()
        );
    }

    public function findByName(string $name): ?Storage
    {
        $storageDoctrine = $this->findOneBy(['name' => $name]);

        if(!$storageDoctrine) return null;
        return new Storage(
            $storageDoctrine->getName(),
            $storageDoctrine->getCity(),
            $storageDoctrine->getId()
        );
    }
}
