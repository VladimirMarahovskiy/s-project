<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 14.02.19
 * Time: 12:40
 */

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseController extends AbstractController
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack;
    }

}