<?php
require_once __DIR__.'/Plugin.php';
class AnimatedCaptcha_Plugin_MovingRectangle extends AnimatedCaptcha_Plugin
{
    protected $_options = array(
        'text'            => '',
        'textSize'        => 3,
        'textColor'       => '000000',
        'backgroundColor' => 'ffffff',
        'foregroundColor' => '000000',
        'windowWidth'     => 30,
        'pixelPerFrame'   => 5,
    );

    /**
     * Returns the single frames of the gif
     */
    protected function _createFrames()
    {
        list($imageWidth, $imageHeight) = $this->_getImageWidthAndHeight();

        for ($i=-$this->_options['windowWidth']; $i<$imageWidth; $i+=$this->_options['pixelPerFrame']) {
            $image = $this->_getBaseImage();

            $foregroundColor = $this->_getColor($image, $this->_options['foregroundColor']);

            // left foreground rectangle
            imagefilledrectangle($image, 0, 0, $i, $imageHeight, $foregroundColor);
            // right foreground rectangle
            imagefilledrectangle($image, $i+$this->_options['windowWidth'], 0, $imageWidth, $imageHeight, $foregroundColor);

            $this->_addImage($image);
        }
    }
}