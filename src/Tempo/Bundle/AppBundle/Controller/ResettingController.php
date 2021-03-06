<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Form\Type\ResettingFormType;

class ResettingController extends Controller
{
    /**
     * Request reset user password: show form
     */
    public function requestAction()
    {
        $error = '';
        return $this->render('TempoAppBundle:Resetting:request.html.twig', array(
            'error'         => $error
        ));
    }

    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        $user = $this->getManager('user')->findUserByUsernameOrEmail($username);
        if (null === $user) {
            return $this->render('TempoAppBundle:Resetting:request.html.twig', array(
                'invalid_username' => $username
            ));
        }

        if ($user->isPasswordRequestNonExpired(5)) {
            $this->addFlash('warning', 'tempo.security.resetting.request_non_expire');
        }

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($user->generateToken());
        }

        $senderEmail = $this->container->getParameter('tempo.config.email_from');

        $message = \Swift_Message::newInstance()
            ->setSubject('[Tempo] Reset password')
            ->setFrom($senderEmail)
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView('TempoAppBundle:Mail:User/reset.html.twig', array('user' => $user)),
                'text/html'
            );

        $test  = $this->get('mailer')->send($message);
        $user->setPasswordRequestedAt(new \DateTime('now', new \DateTimeZone('UTC')));
        $this->getManager('user')->save($user);

        $this->addFlash('success', 'tempo.security.resetting.request_success');

        return $this->redirectToRoute('homepage');
    }

    public function resetAction(Request $request, $token)
    {
        $userManager = $this->getManager('user');
        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if ($user->isPasswordRequestNonExpired(5)) {
            $this->addFlash('warning', 'tempo.security.resetting.request_non_expire');
        }

        $form = $this->createForm(new ResettingFormType(), $user);

        if ($form->handleRequest($request)->isValid()) {
            $this->getManager('user')->save($user);
            $this->addFlash('success', 'tempo.security.resetting.request_success_reset');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('TempoAppBundle:Resetting:reset.html.twig', array(
            'form' => $form->createView(),
            'token' => $token
        ));

    }
}
