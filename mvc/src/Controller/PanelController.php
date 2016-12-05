<?php

namespace Controller;

use Zanra\Framework\Controller\Controller;
use Entity\Panel;

class PanelController extends Controller
{
    public function AddAction()
    {
    	$code = 404;
    	$errors = array();
        $extras = array();

    	// verifier que le panel à rajouter appartienne bien à la session du tableau actuelle
    	// hack possible
    	// Todo...

    	if (empty($_POST['title'])) {
    		$errors['title'] = "title can't be empty";
    	}

    	if (empty($errors)) {

	    	$em = \Model\Doctrine::getInstance()->getEntityManager();
            $em->getConnection()->beginTransaction();

            try {

    	    	$panel = new Panel();

    	    	$panel->setTitle($_POST['title']);
    	    	$em->persist($panel);
                $em->flush();

    	    	$insertedId = $panel->getId();

    	    	if ($insertedId <= 0 ) {
    	    		throw new \Exception("Panel can't be added", 404);
    	    	}

                $panel->setPosition($insertedId);
                $em->persist($panel);
                $em->flush();

                $em->getConnection()->commit();

                $extras = array('id' => $insertedId);

                $code = 200;

            } catch (Exception $e) {
                // Rollback the failed transaction attempt
                $em->getConnection()->rollback();
                throw $e;
            }

	    }

        return json_encode(array('code' => $code, 'errors' => $errors, 'extras' => $extras));
    }

    public function ArchiveAction()
    {
        $code = 404;
        $errors = array();

        // verifier que le panel à rajouter appartienne bien à la session du tableau actuelle
        // hack possible
        // Todo...

        if (empty($_GET['id'])) {
            $errors['id'] = "panel id can't be empty";
        }

        if (empty($errors)) {

            $em = \Model\Doctrine::getInstance()->getEntityManager();
            $panel = $em->getRepository('Entity\Panel')->findOneById($_GET['id']);

            if (!$panel) {
                throw new \Exception("Panel to archive not found", 404);   
            }

            $panel->setStatus(1);
            $em->flush();

            $code = 200;
        }

        return json_encode(array('code' => $code, 'errors' => $errors));
    }

    public function SortAction()
    {
        $code = 404;
        $errors = array();

        // verifier que le panel à rajouter appartienne bien à la session du tableau actuelle
        // hack possible
        // Todo...

        if (empty($_POST['panels'])) {
            $errors['panels'] = "panels can't be empty";
        }        

        if (empty($errors)) {

            $em = \Model\Doctrine::getInstance()->getEntityManager();

            $em->getConnection()->beginTransaction();

            parse_str($_POST['panels'], $dataPanels);

            $sortPanels = $dataPanels['panel'];

            try {

                foreach ($sortPanels as $position => $panelId) {

                    $panel = $em->getRepository('Entity\Panel')->findOneById($panelId);

                    $panel->setPosition($position);

                    $em->persist($panel);
                    $em->flush();
                }

                $em->getConnection()->commit();

                $code = 200;

            } catch (Exception $e) {
                // Rollback the failed transaction attempt
                $em->getConnection()->rollback();
                throw $e;
            }
        }

        return json_encode(array('code' => $code, 'errors' => $errors));
    }
}
