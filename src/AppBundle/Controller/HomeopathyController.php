<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Homeopathy;
use AppBundle\Form\HomeopathyType;

/**
 * Homeopathy controller.
 *
 * @Route("/homeopathy")
 */
class HomeopathyController extends Controller
{
    /**
     * Lists all Homeopathy entities.
     *
     * @Route("/", name="homeopathy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $homeopathies = $em->getRepository('AppBundle:Homeopathy')->findBy(array(
            'usr_id' => $this->getUser()->getId()
        ));
        //findAll();

        return $this->render('homeopathy/index.html.twig', array(
            'homeopathies' => $homeopathies,
        ));
    }

    /**
     * Creates a new Homeopathy entity.
     *
     * @Route("/new", name="homeopathy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $homeopathy = new Homeopathy($this->getUser());
       // $homeopathy->setUsrId();
        $form = $this->createForm('AppBundle\Form\HomeopathyType', $homeopathy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $homeopathy->setQty(    abs($homeopathy->getQty() )  );
            $em = $this->getDoctrine()->getManager();
            $em->persist($homeopathy);
            $em->flush();

            return $this->redirectToRoute('homeopathy_show', array('id' => $homeopathy->getId()));
        }

        return $this->render('homeopathy/new.html.twig', array(
            'homeopathy' => $homeopathy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Homeopathy entity.
     *
     * @Route("/{id}", name="homeopathy_show")
     * @Method("GET")
     */
    public function showAction(Homeopathy $homeopathy)
    {
        if( $this->getUser()->getRole()->getId() != 2 )
        {
            if( $this->getUser()->getId() != $homeopathy->getUsrId()->getId() )
            {
                return $this->redirectToRoute('homeopathy', array(), 301);
            }
        }
            $deleteForm = $this->createDeleteForm($homeopathy);

            return $this->render('homeopathy/show.html.twig', array(
                'homeopathy' => $homeopathy,
                'delete_form' => $deleteForm->createView(),
            ));

    }

    /**
     * Displays a form to edit an existing Homeopathy entity.
     *
     * @Route("/{id}/edit", name="homeopathy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Homeopathy $homeopathy)
    {
        if ($this->getUser()->getId() != $homeopathy->getUsrId()->getId()) {
            return $this->redirectToRoute('homeopathy', array(), 301);
        }
        else
        {
            $deleteForm = $this->createDeleteForm($homeopathy);
            $editForm = $this->createForm('AppBundle\Form\HomeopathyType', $homeopathy);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {

                $homeopathy->setQty(    abs($homeopathy->getQty() )  );
                $em = $this->getDoctrine()->getManager();
                $em->persist($homeopathy);
                $em->flush();

                return $this->redirectToRoute('homeopathy_edit', array('id' => $homeopathy->getId()));
            }

            return $this->render('homeopathy/edit.html.twig', array(
                'homeopathy' => $homeopathy,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Deletes a Homeopathy entity.
     *
     * @Route("/{id}", name="homeopathy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Homeopathy $homeopathy)
    {
        if( ($this->getUser()->getId() != $homeopathy->getUsrId()->getId()) && $this->getUser()->getRole()->getId() !=2)
        {
            return $this->redirectToRoute('homeopathy', array(), 301);
        }

            $form = $this->createDeleteForm($homeopathy);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($homeopathy);
                $em->flush();
            }

        return $this->redirectToRoute('homeopathy_index');
    }

    /**
     * Creates a form to delete a Homeopathy entity.
     *
     * @param Homeopathy $homeopathy The Homeopathy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Homeopathy $homeopathy)
    {
        if($this->getUser()->getId() != $homeopathy->getUsrId()->getId()  && $this->getUser()->getRole()->getId() !=2)
        {
            return $this->redirectToRoute('homeopathy', array(), 301);
        }

            return $this->createFormBuilder()
                ->setAction($this->generateUrl('homeopathy_delete', array('id' => $homeopathy->getId())))
                ->setMethod('DELETE')
                ->getForm();

    }

    /**
     * @param Homeopathy $homeopathy
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function increaseHomAction(Request $request, Homeopathy $homeopathy)
    {
        if($this->getUser()->getId() != $homeopathy->getUsrId()->getId()  && $this->getUser()->getRole()->getId() !=2)
        {
            return $this->redirectToRoute('homeopathy', array(), 301);
        }
        $homeopathy->setQty( (($homeopathy->getQty())+1) );
        $em = $this->getDoctrine()->getManager();
        $em->persist($homeopathy);
        $em->flush();
        return $this->redirectToRoute('homeopathy');
    }

    /**
     * @param Homeopathy $homeopathy
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method("GET")
     */
    public function decreaseHomAction(Request $request, Homeopathy $homeopathy)
    {
        if($this->getUser()->getId() != $homeopathy->getUsrId()->getId()  && $this->getUser()->getRole()->getId() !=2)
        {
            return $this->redirectToRoute('homeopathy', array(), 301);
        }
        if($homeopathy->getQty() > 0)
        {
        $homeopathy->setQty( (($homeopathy->getQty() )-1) );
        $em = $this->getDoctrine()->getManager();
        $em->persist($homeopathy);
        $em->flush();
        }
        return $this->redirectToRoute('homeopathy');
    }

}
