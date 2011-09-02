<?php

// Example for the RollingBall Plugin

$pluginOptions = array(
    'text'            => 'PHPGangsta',
    'textSize'        => 4,
    'textColor'       => '000000',
    'backgroundColor' => 'ffffff',
    'foregroundColor' => '000000',
);

require_once 'AnimatedCaptcha.php';
$animatedCaptcha = new AnimatedCaptcha();
$animatedCaptcha->setMillisecondsBetweenFrames(10)
                ->setPluginName('RollingBall')
                ->setPluginOptions($pluginOptions)
                ->render();
$gifContent = $animatedCaptcha->getRenderedFileContent();
// now you can save it, output it or whatever.