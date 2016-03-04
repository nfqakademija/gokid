<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    public function worldAction()
    {
        return $this->render('AppBundle:Hello:world.html.twig', array(
            // ...
        ));
    }

}
