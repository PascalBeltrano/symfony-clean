<?php

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Item\Entity\Item;
use Domain\Item\Gateway\ItemGateway;
use Exception;
use Infrastructure\Doctrine\Entity\ItemDoctrine;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository implements ItemGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemDoctrine::class);
    }

    public function create(Item $item): Item
    {
        $itemDoctrine = new ItemDoctrine();

        $itemDoctrine->setName($item->getName());
        $itemDoctrine->setPrice($item->getPrice());

        $this->_em->persist($itemDoctrine);
        $this->_em->flush();

        return new Item(
            $itemDoctrine->getName(),
            $itemDoctrine->getPrice(),
            $itemDoctrine->getId()
        );
    }

    public function update(Item $item): Item
    {
        /** @var ?ItemDoctrine $itemDoctrine */
        $itemDoctrine = $this->find($item->getId());

        $itemDoctrine->setName($item->getName());
        $itemDoctrine->setPrice($item->getPrice());

        $this->_em->persist($itemDoctrine);
        $this->_em->flush();

        return new Item(
            $itemDoctrine->getName(),
            $itemDoctrine->getPrice(),
            $itemDoctrine->getId()
        );
    }

    public function delete (Item $item): bool
    {

        $itemDoctrine = $this->find($item->getId());

        try
        {
            $this->_em->remove($itemDoctrine);
            $this->_em->flush();
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function findById(int $id): ?Item
    {
        $itemDoctrine = $this->find($id);

        if(!$itemDoctrine) return null;
        return new Item(
            $itemDoctrine->getName(),
            $itemDoctrine->getPrice(),
            $itemDoctrine->getId()
        );
    }

    public function findByName(string $name): ?Item
    {
        $itemDoctrine = $this->findOneBy(['name' => $name]);

        if(!$itemDoctrine) return null;
        return new Item(
            $itemDoctrine->getName(),
            $itemDoctrine->getPrice(),
            $itemDoctrine->getId()
        );
    }

    public function findOtherWithSameName(int $id, string $name): ?Item
    {

        $itemDoctrine = $this->createQueryBuilder('i')
            ->where('i.name = :name')
            ->andWhere('i.id <> :excludedId')
            ->setParameters([
                'name' => $name,
                'excludedId' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if($itemDoctrine == null) return null;

        return new Item(
            $itemDoctrine->getName(),
            $itemDoctrine->getPrice(),
            $itemDoctrine->getId()
        );
    }

    public function getAll(): array
    {
        $itemsDoctrine = $this->findAll();
        $results = array();
        
        foreach($itemsDoctrine as $itemDoctrine)
        {
            $item = new Item(
                $itemDoctrine->getName(),
                $itemDoctrine->getPrice(),
                $itemDoctrine->getId()
            );
            array_push($results, $item);
        }

        return $results;
    }
}
