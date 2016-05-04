<?php
namespace UserBundle\Controller;

use AppBundle\Entity\Offer;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    /**
     * Method overriding the default FOSUserBundle registration action.
     * Allows the offer registration action to pass user data, to
     * register a user, when registering an offer. Requires the
     * offer to be registered to be passed to it.
     *
     * @param Request $request
     * @param Offer|null $offer
     * @return null|RedirectResponse|Response
     */
    public function registerAction(Request $request, Offer $offer = null)
    {
        // Redirect authenticated users to homepage
        if ($this->container->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('app.index'));
        }
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        // States whether request to register a user came from another
        // controller.
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_edit');
                $response = new RedirectResponse($url);
            }
            $dispatcher->dispatch(
                FOSUserEvents::REGISTRATION_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );
            // Remove the default FOSUserBundle account registration success
            // flash message.
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash('success', 'Jūsų paskyra sukurta');
            return $response;
        }
        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
