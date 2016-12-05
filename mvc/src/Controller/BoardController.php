<?php

namespace Controller;

use Zanra\Framework\Controller\Controller;
use Entity\Panel;

class BoardController extends Controller
{
    public function IndexAction()
    {
    	$em = \Model\Doctrine::getInstance()->getEntityManager();

    	$panels = $em->getRepository('Entity\Panel')->findBy(array('status' => null), array('position' => 'ASC'));

        return $this->render('Board/index.html.twig', array('panels' => $panels));
    }
}
