<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * Home page index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Home:index.html.twig', array(
            // ...
        ));
    }

    /**
     * User login action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return $this->render('AppBundle:Home:login.html.twig', array(

        ));
    }

    /**
     * Coach info action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coachesAction()
    {
        return $this->render('AppBundle:Home:coaches.html.twig', array(

        ));
    }
}
