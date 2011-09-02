<?php

// Example for the MovingRectangle Plugin

$pluginOptions = array(
    'text'            => 'PHPGangsta',
    'textSize'        => 3,
    'textColor'       => '000000',
    'backgroundColor' => 'ffffff',
    'foregroundColor' => '000000',
    'windowWidth'     => 30,
    'pixelPerFrame'   => 2,
);

require_once 'AnimatedCaptcha.php';
$animatedCaptcha = new AnimatedCaptcha();
$animatedCaptcha->setMillisecondsBetweenFrames(10)
                ->setPluginName('MovingRectangle')
                ->setPluginOptions($pluginOptions)
                ->render()
                ->outputRenderedImage();