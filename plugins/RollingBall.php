<?php
require_once __DIR__.'/Plugin.php';
class AnimatedCaptcha_Plugin_RollingBall extends AnimatedCaptcha_Plugin
{
    protected $_options = array(
        'text'            => '',
        'textSize'        => 3,
        'textColor'       => '000000',
        'backgroundColor' => 'ffffff',
        'foregroundColor' => '000000',
    );

    /**
     * Returns the single frames of the gif
     */
    protected function _createFrames()
    {
        list($imageWidth, $imageHeight) = $this->_getImageWidthAndHeight();

        for ($i=-floor($imageHeight/2); $i<$imageWidth+floor($imageHeight/2); $i+=2) {
            $image = $this->_getBaseImage();

            $foregroundColor = $this->_getColor($image, $this->_options['foregroundColor']);

            imagefilledellipse($image, $i, floor($imageHeight/2), $imageHeight, $imageHeight, $foregroundColor);

            $this->_addImage($image);
        }
    }
}