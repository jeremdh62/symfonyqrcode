<?php

namespace App\Services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QrcodeService 
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder) 
    {
        $this->builder = $builder;
        
    }

    public function qrcode($query)
    {
        $url = "https://www.qwant.com/?q=";

        // Set qrcode
        $result = $this->builder
        ->data($url.$query)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(400)
        ->margin(10)
        ->labelText('Recherche sur Qwant')
        ->build()
        ;

        // Generate name
        $namePng = uniqid('','').'.png';

        // Save img png
        $result->saveToFile( (\dirname(__DIR__, 2).'/public/assets/qr-code/'.$namePng) );

        return $result->getDataUri();
    }
}