PortableDocumentBundle
======================

PortableDocumentBundle is a PHP (5.3+) wrapper for the mPDF Library.
It allows you to generate pdfs from html.

Installation
------------

With [composer](http://packagist.org), add:

```json
{
    "require": {
        "prg/portabledocument-bundle": "dev-master"
    }
}
```

Then enable it in your kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        //...
        new PRG\PortableDocumentBundle\PRGPortableDocumentBundle(),
        //...
```

### Render a pdf document as response from a controller

```php
$pdfGenerator = $this->get('pguso.mpdf');

$html = $this->renderView('YourBundle:Folder:file.html.twig', array(
            'args' => $args
        ));

return new Response(
          $pdfGenerator->generateFromView($html, array(
                'stylesheet' => '/pdf/style.css' //optional
            ))
        );
```
