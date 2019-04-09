<?php

namespace App\Admin\Controller;

use App\Entity\Resources;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

class ResourcesAdminController extends CRUDController
{
    public function listAction()
    {
        if($this->isXmlHttpRequest()){
            return parent::listAction();
        }
        $resources = $this->getDoctrine()->getRepository(Resources::class)->getResourcesTree();

        return $this->render('admin/resources/list.html.twig',
            ['resources' => $resources]);
    }

}