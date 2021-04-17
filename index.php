<?php 
// a php project to learn how to generate qrcode using libraries:
    // 1- Chillerlan
    // 2- Endroid
//

//-------------------------------------------------------------------
//              QR code generator using chillerlan libarary
//-------------------------------------------------------------------
//1- to use a class or a library that been installed by composer, you must require autoload.php first: 
require "vendor/autoload.php";

/*
//2- then, open the class php file.. and use it like this: 
    //use "namespace" + "\" + "class name;"
//here's a real life example: 
use chillerlan\QRCode\QRCode;


//3- do your code, and use the tools from the imported libraries:
$data = 'https://google.com';
echo '<img src="'.(new QRCode)->render($data).'" alt="QR Code" />';

*/



//-------------------------------------------------------------------
//              QR code generator using Endroid libarary
//-------------------------------------------------------------------
//same steps but i'm gonna use Endroid library: 

///I'm gonna use same endroid just like the example in github,

///--------------------------
/// 1- Endroid With builder (which means you will add image and colors in same line):
///--------------------------
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

$result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data('Custom QR code contents')
    ->encoding(new Encoding('UTF-8'))
    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
    ->size(300)
    ->margin(10)
    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->labelText('This is the label')
    ->labelFont(new NotoSans(20))
    ->labelAlignment(new LabelAlignmentCenter())
    ->build();
$dataUri= $result->getDataUri();

echo '<img src="' . $dataUri . '" alt="">';
echo '<br>';
echo $dataUri;

//next is the simplest way for using this library:    
$result = Builder::create()
    ->data('Custom QR code contents')
    ->build();

////Directly output the QR code, as a html image page: 
//header('Content-Type: '.$result->getMimeType());
//echo $result->getString();

// Generate a data URI to include image data inline (i.e. inside an <img> tag)
//.. which means that we Get the same image but inside an image tag using URI:
$dataUri= $result->getDataUri();

echo '<img src="' . $dataUri . '" alt=""> <br>';


///--------------------------
/// 2- Endroid Without builder (image and colors add separetly):
///--------------------------
    
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create('Data')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
//.. i noticed that the qr code can only be readable if image is <=50 px for a 300px qr code: 
$logo = Logo::create(__DIR__.'/assets/symfony.png')
    ->setResizeToWidth(50);

// Create generic label
$label = Label::create('Label')
    ->setTextColor(new Color(255, 0, 0))
    ->setBackgroundColor(new Color(0, 0, 0));

$result = $writer->write($qrCode, $logo, $label);

$dataUri= $result->getDataUri();

echo '<img src="' . $dataUri . '" alt="">';