<?php

namespace App\Admin\Controller;

use App\Entity\Resources;
use Sonata\AdminBundle\Controller\CRUDController;

class ResourcesAdminController extends CRUDController
{
    public function listAction()
    {
        $resources = $this->getDoctrine()->getRepository(Resources::class)->getResourcesTree();

        return $this->render('admin/resources/list.html.twig',
            ['resources' => $resources]);
    }
}