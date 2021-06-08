<?php

namespace App\Services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;
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

        $path = (\dirname(__DIR__, 2).'/public/assets/');

        // Set qrcode
        $result = $this->builder
        ->data($url.$query)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(400)
        ->margin(10)
        ->labelText('Recherche sur Qwant')
        ->backgroundColor(new Color('232','232','233'))
        ->logoPath($path.'img/logo.png')
        ->logoResizeToWidth('75')
        ->logoResizeToHeight('75')
        ->build()
        ;

        // Generate name
        $namePng = uniqid('','').'.png';

        // Save img png
        $result->saveToFile( $path .'qr-code/'.$namePng);

        return $result->getDataUri();
    }
}