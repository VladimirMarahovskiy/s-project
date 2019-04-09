<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

final class ResourcesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $resource = $this->getSubject();
        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => false];
        $defaultOptions = ['required' => false];
        if ($resource && $webPath = $resource->getImagePath()) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            //$container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100px" src="' . $webPath . '" class="admin-preview"/>';
        }

        $formMapper
            ->tab('General')// the tab call is optional
            ->with('Content', [
                'class' => 'col-md-8',
                //'box_class' => 'box box-solid box-info',
                // 'description' => 'Lorem ipsum',

            ])
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('description', TextareaType::class, $defaultOptions)
            ->add('content', TextareaType::class, $defaultOptions)
            ->add('file', FileType::class, $fileFieldOptions)
            ->end()
            ->with('Action', [
                'class' => 'col-md-4',
            ])
            ->add('is_active', CheckboxType::class, $defaultOptions)
            ->add('is_publish', CheckboxType::class, $defaultOptions)
            ->add('template', ModelType::class, $defaultOptions)
            ->add('parent', ModelListType::class, $defaultOptions)
            ->end()
            ->end()
            ->tab('Template Fields')// the tab call is optional
            ->with('Fields', [
                'class' => 'col-md-12',
            ])
            ->end()
            ->end();
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->upload();
        }
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('is_active')
            ->add('is_publish');
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper->addIdentifier('name');
    }
}