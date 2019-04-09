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

class ListView extends AbstractController
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


    public function view($params)
    {
        if ($this->prepareParams($params)) {

            $resources = $this->entityManager->getRepository(Resources::class)->getList($this->params);
            if($resources) {
                foreach ($resources as $key => $resource) {
                    echo $this->renderView($this->params['template'], array_merge($resource, ['key' => $key]));
                }
            }
        } else {
            return $this->createNotFoundException();
        }
    }

    private function prepareParams(array $params)
    {
        if (isset($params['parent'])) {
            $this->params['parent'] = $params['parent'];

        } else {
            return false;
        }
        if (isset($params['template']) /*&& $this->get('templating')->exists('chank:'.$params['template'].'.html.twig')*/) {
            $this->params['template'] = 'chank/' . $params['template'] . '.html.twig';
        } else {
            return false;
        }

        $this->params['isPublished'] = $params['is_published'] ?? 1;
        $this->params['depth'] = $params['depth'] ?? 0;
        $this->params['fields'] = isset($params['fields']) ? explode(',', $params['fields']) : '';
        $this->params['content'] = $params['content'] ?? 0;
        $this->params['sortBy'] = $params['sortBy'] ?? 'id';
        $this->params['sortDir'] = $params['sortDir'] ?? 'ASC';
        $this->params['limit'] = $params['limit'] ?? 10;
        $this->params['offset'] = $params['offset'] ?? 0;
        $this->params['where'] = $params['where'] ?? false;
        $this->params['whereFields'] = $params['whereFields'] ?? false;

        return true;
    }


}