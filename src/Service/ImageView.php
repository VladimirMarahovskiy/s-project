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

class ImageView extends AbstractController
{

    /*
     * */
    private $entityManager;
    private $params;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function main(string $src)
    {
        if (!empty($src)) {

            return Resources::WEB . $src;

        } else {
            $this->createNotFoundException();
        }
    }


    public function thumb($src, $width = 100, $height = 100)
    {
        if (!empty($src)) {

            return Resources::WEB . $src;

        } else {
            $this->createNotFoundException();
        }
    }


}