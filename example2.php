<?php

// Example for the Snow Plugin

$pluginOptions = array(
    'text'            => 'PHPGangsta',
    'textSize'        => 4,
    'textColor'       => '000000',
    'backgroundColor' => 'ffffff',
    'foregroundColor' => '000000',
    'strength'        => 20,
);

require_once 'AnimatedCaptcha.php';
$animatedCaptcha = new AnimatedCaptcha();
$animatedCaptcha->setMillisecondsBetweenFrames(10)
                ->setPluginName('Snow')
                ->setPluginOptions($pluginOptions)
                ->render()
                ->outputRenderedImage();