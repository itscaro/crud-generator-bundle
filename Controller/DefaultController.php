<?php

namespace Itscaro\CrudGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ItscaroCrudGeneratorBundle:Default:index.html.twig', array('name' => $name));
    }
}
