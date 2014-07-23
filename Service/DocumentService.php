<?php

namespace PRG\PortableDocumentBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use mPDF;


/**
 * Class DocumentService
 * @package PRG\PortableDocumentBundle\Service
 */
class DocumentService extends Controller {

    /**
     * @param ContainerInterface $container
     * @internal param \Symfony\Bridge\Doctrine\RegistryInterface $doctrine
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $mpdf = new mPDF('utf-8', 'A4');
        $this->mpdf = $mpdf;
    }

    /**
     * @param $html
     * @param array $args
     * @return string
     */
    public function generateFromView($html, $args = array())
    {
        $filename = $args['filename'];
        $path = $args['path'];
        $pathToStylesheet = $this->getAbsoluteWebRoot() . $args['stylesheet'];
        $title = $args['title'];

        if(is_file($pathToStylesheet)) {
            $stylesheet = file_get_contents($pathToStylesheet);
            $this->mpdf->WriteHTML($stylesheet, 1);
        }

        $this->mpdf->SetTitle($title);

        $this->mpdf->WriteHTML($html);

        return $this->mpdf->Output($filename, $path);
    }

    /**
     * @return string
     */
    public function getAbsoluteWebRoot() {
        $documentRoot = $this->get('request_stack')->getCurrentRequest()->server->get('DOCUMENT_ROOT');
        $webRoot = $this->get('request_stack')->getCurrentRequest()->getBasePath();

        return $documentRoot . $webRoot;
    }

}