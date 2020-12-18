<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Gift;
use App\Event\CommentCreatedEvent;
use App\Form\GiftType;
use App\Form\CommentType;
use App\Repository\GiftRepository;
use App\Repository\TagRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GiftController extends AbstractController
{

    /**
     * @Route("/ajout-cadeau", name="addGift")
     */
    public function addGift( Request $request){

        $gift = new Gift();

        $form = $this->createForm(GiftType::class, $gift , [
            'action' => $this->generateUrl('addGift'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()
//            && $form->isValid()
        ) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $gift = $form->getData();
            $gift->setSlug( $gift->getTitle() );
            $u = $this->getUser();
            $gift->setAuthor( $u );

            if( empty($gift->getContent()) ){
                $gift->setContent(' ');
            }



            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($gift);
             $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('app/gifts/_modal.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/supprimer-cadeau/{id}", name="deleteGift")
     */
    public function deleteGift($id){

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Gift::class);

        $gg = $repository->findOneBy(['id' => $id]);
        if( $gg ){
            $em->remove($gg);
            $em->flush();
        } else {
            print_r('Aucun cadeau trouvé pour id : '.$id);
            exit();
        }
        return $this->redirectToRoute('homepage');

    }

    public function _list($u = null, $max = null){

//        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Gift::class);


        if($u != null){
            $ggs = $repository->findAll(['author' => $u]);
        } else {
            $ggs = $repository->findAll();
        }

        return $this->render(
            'app/gifts/_list.html.twig',
            ['gifts' => $ggs]
        );



    }


}
