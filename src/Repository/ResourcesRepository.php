<?php

namespace App\Repository;

use App\Entity\Resources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Resources|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resources|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resources[]    findAll()
 * @method Resources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourcesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resources::class);
    }

    public function getResourceBySlug(string $slug)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getList(array $params)
    {

        return $this->createQueryBuilder('r')
            /* ->andWhere('r.exampleField = :val')
             ->setParameter('val', $value)
             ->orderBy('r.id', 'ASC')
             ->setMaxResults(10)*/
            ->getQuery()
            ->getArrayResult();
    }

    public function getResourcesTree()
    {

        $rows = $this->createQueryBuilder('r')
            ->select('r.id,r.name,r.level, p.id as parent_id')
            ->leftJoin('r.parent', 'p')
            ->getQuery()
            ->getArrayResult();

        return $this->buildTree($rows);

    }

    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            $id = $element['parent_id'] ?? 0;
            if ($id == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }


//    /**
//     * @return Resources[] Returns an array of Resources objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resources
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
