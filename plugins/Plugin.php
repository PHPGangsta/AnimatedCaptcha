<?php

abstract class AnimatedCaptcha_Plugin
{
    protected $_options = array();
    protected $_frames;

    public function __construct($options)
    {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                if (isset($this->_options[$key])) {
                    $this->_options[$key] = $value;
                }
            }
        }
    }

    /**
     * Returns the single frames of the gif
     *
     * @return array
     */
    abstract protected  function _createFrames();

    public function getFrames() {
        $this->_createFrames();

        return $this->_frames;
    }

    /**
     * Get width and height of the label
     *
     * @return array
     */
    protected function _getImageWidthAndHeight()
    {
        $imageWidth = strlen($this->_options['text']) * imagefontwidth($this->_options['textSize']);
        $imageHeight = imagefontheight($this->_options['textSize']);

        return array($imageWidth, $imageHeight);
    }

    /**
     * Create a base image with the text
     *
     * @return resource
     */
    protected function _getBaseImage()
    {
        list($imageWidth, $imageHeight) = $this->_getImageWidthAndHeight();

        $image = imagecreatetruecolor($imageWidth, $imageHeight);

        $textColor       = $this->_getColor($image, $this->_options['textColor']);
        $backgroundColor = $this->_getColor($image, $this->_options['backgroundColor']);

        // background
        imagefilledrectangle($image, 0, 0, $imageWidth, $imageHeight, $backgroundColor);

        // write the text
        imagestring($image, $this->_options['textSize'], 0, 0, $this->_options['text'], $textColor);

        return $image;
    }

    protected function _getColor($image, $color)
    {
        return imagecolorallocate(
            $image,
            hexdec(substr($color, 0, 2)),
            hexdec(substr($color, 2, 2)),
            hexdec(substr($color, 4, 2))
        );
    }

    protected function _addImage($image)
    {
        ob_start();
        imagegif($image);
        $gifContent = ob_get_contents();
        ob_end_clean();

        $this->_frames[] = $gifContent;
    }
}