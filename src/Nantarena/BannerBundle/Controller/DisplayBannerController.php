<?php

namespace Nantarena\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Manage routing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Entity
use Nantarena\BannerBundle\Entity\HeaderNews;
use Nantarena\BannerBundle\Entity\SponsorSlide;

class DisplayBannerController extends Controller
{
    public function indexAction()
    {
        // get Header news
        $repository = $this->getDoctrine()
            ->getRepository('NantarenaBannerBundle:HeaderNews');
        $hnews = $repository->findOneBy(array('active' => True));

        if ($hnews)
            $content = $hnews->getContent();
        else
            $content = '';

        // get Sponsor slide
        $repository = $this->getDoctrine()
            ->getRepository('NantarenaBannerBundle:SponsorSlide');
        $slides = $repository->findBy(array( 'active' => True));

        $nbslides = sizeof($slides) -1;
        if ($nbslides > 0)
            $num = rand(0, $nbslides);
        else
            $num = 0;

        return $this->render('NantarenaBannerBundle:Banner:banner.html.twig', 
            array(
                'content' => $content, 
                'slides' => $slides,
                'num' => $num,));
    }
}
