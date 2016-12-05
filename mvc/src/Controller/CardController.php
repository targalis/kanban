<?php

namespace Controller;

use Zanra\Framework\Controller\Controller;
use Entity\Card;
use Entity\Panel;

class CardController extends Controller
{
    public function AddAction()
    {
    	$code = 400;
    	$errors = array();
    	$extras = array();

    	// verifier que le panel et la carte à rajouter appartienne bien à la session du tableau actuelle
    	// hack possible
    	// Todo...

    	if(empty($_POST['panel'])) {
    		$errors['panel'] = "panel id missing";
    	}

    	if(empty($_POST['title'])) {
    		$errors['title'] = "title can't be empty";
    	}

    	if(empty($errors)) {

    		$em = \Model\Doctrine::getInstance()->getEntityManager();
            $em->getConnection()->beginTransaction();

            try {

    	    	$panel = $em->getRepository('Entity\Panel')->findOneById($_POST['panel']);

    	    	$card = new Card();

	    		$card->setTitle($_POST['title']);
	    		$card->setPanel($panel);

    	    	$em->persist($card);
	    		$em->flush();

    	    	$insertedId = $card->getId();

    	    	if ($insertedId <= 0 ) {
    	    		throw new \Exception("Card can't be added", 404);
    	    	}

                $card->setPosition($insertedId);
                $em->persist($card);
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
            $errors['id'] = "card id can't be empty";
        }

        if (empty($errors)) {

            $em = \Model\Doctrine::getInstance()->getEntityManager();

            $card = $em->getRepository('Entity\Card')->findOneById($_GET['id']);

            if (!$card) {
                throw new \Exception("Card to archive not found", 404);   
            }

            $card->setStatus(1);
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

        if (empty($_POST['panel'])) {
            $errors['panel'] = "panel id for sorting can't be empty";
        }

		if (empty($_POST['cards'])) {
            $errors['cards'] = "cards can't be empty";
        }        

        if (empty($errors)) {

            $em = \Model\Doctrine::getInstance()->getEntityManager();

            $em->getConnection()->beginTransaction();

            parse_str($_POST['cards'], $dataCards);

            $sortCards = $dataCards['card'];

            try {

            	$panel = $em->getRepository('Entity\Panel')->findOneById($_POST['panel']);

            	foreach ($sortCards as $position => $cardId) {

            		$card = $em->getRepository('Entity\Card')->findOneById($cardId);

            		$card->setPanel($panel);
            		$card->setPosition($position);

    	    		$em->persist($card);
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
