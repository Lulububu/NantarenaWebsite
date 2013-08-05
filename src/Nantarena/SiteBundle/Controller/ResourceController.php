<?php

namespace Nantarena\SiteBundle\Controller;

use Nantarena\SiteBundle\Entity\Resource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceController extends Controller
{
    /**
     * @Route("/admin/resource/{id}", name="nantarena_site_resource")
     */
    public function showAction(Resource $resource)
    {
        $path = $resource->getUploadRootDir().'/'.sha1($resource->getId()).'.'.$resource->getExtension();

        if (file_exists($path)) {
            $content = file_get_contents($path);

            $finfo = new \finfo();
            $mimeType = $finfo->file($path, FILEINFO_MIME_TYPE);

            $response = new Response();
            $response->headers->set('Content-Type', $mimeType);
            $response->headers->set('Content-Disposition', 'attachment;filename="'.$resource->getName());

            $response->setContent($content);
            return $response;
        }

        return new NotFoundHttpException("Resource not found");
    }
}
