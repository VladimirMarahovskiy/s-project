<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 13.02.19
 * Time: 9:30
 */

namespace App\Service;


use App\Entity\Resources;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FieldView extends AbstractController
{

    /*
     * parents - родитель
     * is_published - опубликованые по умолчанию, но если нужно то и неопубликованые
     * depth - глубина дочерних элементов
     * content - включать ли в выборку контент
     * template - чанк вьюхи
     * */
    private $entityManager;
    private $params;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function view(int $resourceId, string $field)
    {
        if (!empty($resourceId) && !empty($field)) {

            $resource = $this->entityManager->getRepository(Resources::class)->getResourceById($resourceId, $field);
            if ($resource) {
                echo $resource[$field];
            }else{
                return $this->createNotFoundException();
            }

        } else {
            return $this->createNotFoundException();
        }
    }

}