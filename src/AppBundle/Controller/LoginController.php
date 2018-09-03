<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function indexAction(AuthenticationUtils $authenticationUtils, Request $request)
    {
        /*$user = new User();
        $loginForm = $this->createFormBuilder($user)
            ->add('email', EmailType::class, array('attr' => ['class' => 'input100', 'placeholder' => 'Email'], 'label' => false))
            ->add('password', PasswordType::class, array('attr' => ['class' => 'input100', 'placeholder' => 'Password'], 'label' => false))
            ->add('login', SubmitType::class, array('attr' => ['class' => 'login100-form-btn', 'style' => 'width: 100%;'], 'label' => 'Login'))
            ->getForm();

        $loginForm->handleRequest($request);

        if($loginForm->isSubmitted() && $loginForm->isValid())
        {
            $email = trim($loginForm['email']->getData());
            $password = trim($loginForm['password']->getData());
            if($email && $password)
            {
                $password = hash('sha512', '123'.hash('sha512', $password).'!@#');
                $repository = $this->getDoctrine()->getRepository(User::class);
                $query = $repository->createQueryBuilder('user')
                    ->where('user.email = :email', 'user.password = :password')
                    ->setParameter('email', $email)
                    ->setParameter('password', $password)
                    ->getQuery();
                $u = $query->getResult();
                if(count($u) && $u[0]->getId())
                {
                    $session = new Session();
                    $session->set('userid', $u[0]->getId());
                    return $this->redirectToRoute('index');
                }
            }
        }*/

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', array(
            // 'loginForm' => $loginForm->createView(),
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
}
