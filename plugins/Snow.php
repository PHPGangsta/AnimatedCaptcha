<?php
require_once __DIR__.'/Plugin.php';
class AnimatedCaptcha_Plugin_Snow extends AnimatedCaptcha_Plugin
{
    protected $_options = array(
        'text'            => '',
        'textSize'        => 3,
        'textColor'       => '000000',
        'backgroundColor' => 'ffffff',
        'foregroundColor' => '000000',
        'strength'        => 20,    // percent of snow
    );

    /**
     * Returns the single frames of the gif
     */
    protected function _createFrames()
    {
        list($imageWidth, ) = $this->_getImageWidthAndHeight();

        for ($i=0; $i<10; $i++) {
            $image = $this->_getBaseImage();

            $foregroundColor = $this->_getColor($image, $this->_options['foregroundColor']);

            // for each pixel check if there is snow and paint snow
            for ($x=0; $x<$imageWidth; $x++) {
                for ($y=0; $y<$imageWidth; $y++) {
                    if (rand(0, 100) < $this->_options['strength']) {
                        imagesetpixel($image, $x, $y, $foregroundColor);
                    }
                }
            }

            $this->_addImage($image);
        }
    }
}