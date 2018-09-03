<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function indexAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $registerForm = $this->createFormBuilder($user)
            ->add('name', TextType::class, array('label' => false,'attr' => ['class' => 'input100', 'placeholder' => 'Name'],))
            ->add('surname', TextType::class, array('label' => false, 'attr' => ['class' => 'input100', 'placeholder' => 'Surname'],))
            ->add('email', EmailType::class, array('label' => false, 'attr' => ['class' => 'input100', 'placeholder' => 'Email'],))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => array('label' => false, 'attr' => ['class' => 'input100', 'placeholder' => 'Password', 'type'=>'password']),
                'second_options' => array('label' => false, 'attr' => ['class' => 'input100', 'placeholder' => 'Repassword', 'type'=>'password'])
            ))
            ->add('register', SubmitType::class, array('attr' => ['class' => 'login100-form-btn', 'style' => 'width: 100%;'], 'label' => 'Register'))
            ->getForm();

        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid())
        {
            if(trim($registerForm['name']->getData()) && trim($registerForm['surname']->getData()) &&
                trim($registerForm['email']->getData()) && trim($registerForm['password']['first']->getData()))
            {
                $formData = $registerForm->getData();
                $emailExists = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($registerForm['email']->getData());
                if(!$emailExists)
                {
                    $password = $registerForm['password']['first']->getData();

                    $userClass = new User();
                    $password = $encoder->encodePassword($userClass, $password);

                    $entityManager = $this->getDoctrine()->getManager();
                    $userClass->setPassword($password);
                    $entityManager->persist($formData);
                    $entityManager->flush();

                    return $this->redirectToRoute('login');
                }
            }
        }

        return $this->render('register/register.html.twig', array(
            'registerForm' => $registerForm->createView(),
        ));
    }
}
