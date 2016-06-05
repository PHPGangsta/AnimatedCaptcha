<?php
/**
 * @author Michael Kliewe
 * @copyright 2011 Michael Kliewe
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link http://www.phpgangsta.de/
 */
class AnimatedCaptcha
{
    protected $_options = array(
		'millisecondsBetweenFrames' => 100,
		'pluginName'                => 'MovingRectangle',
		'pluginOptions'             => array()
										);
    /**
     * @var string
     */
    protected $_tempFilePath;
    /**
     * @var array
     */
    protected $_frames;

    public function __construct(array $options = array())
    {
        if (!class_exists( 'GIFEncoder') && !include('library/GIFEncoder3.0.php')) {
            throw new Exception('GIFEncoder class not found');
        }

        if (is_array($options)) {
            $this->setOptions($options);
        }

        return;
    }

    public function __destruct()
    {
        return;
    }

    /**
     * All given options in the array are given to their setters
     *
     * @param array $options
     * @return ImageLabeler
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $normalized = ucfirst($key);
            $method = 'set' . $normalized;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function setMillisecondsBetweenFrames($ms)
    {
        $this->_options['millisecondsBetweenFrames'] = $ms;
        return $this;
    }

    public function setPluginName($pluginName)
    {
        $this->_options['pluginName'] = $pluginName;
        return $this;
    }

    public function setPluginOptions($pluginOptions)
    {
        $this->_options['pluginOptions'] = $pluginOptions;
        return $this;
    }

    public function render()
    {
        $this->_createTempFilePath();
        $this->_getFramesFromPlugin();
        $this->_writeFramesToTargetFile();
        return $this;
    }

    /**
     * Send header and output the image
     *
     * @return ImageLabeler
     */
    public function outputRenderedImage()
    {
        if(!headers_sent()) {
            header('Cache-Control: private, no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()-60).' GMT');
            header('Pragma: no-cache');
            header('Content-Length: '.filesize($this->_tempFilePath));
            header('Content-Type: image/gif');
        }
        else {
            throw new Exception('Can not send header parameters. Thats already sent.');
        }

        readfile($this->_tempFilePath);
        return $this;
    }

    /**
     * Get the image as a string
     *
     * @return string
     */
    public function getRenderedFileContent()
    {
        return file_get_contents($this->_tempFilePath);
    }

    /**
     * Get the path to the file after render() has been called
     *
     * @return string
     */
    public function getRenderedFilePath()
    {
        return $this->_tempFilePath;
    }


    // ====== private and protected methods =============

    protected function _getFramesFromPlugin()
    {
        require (__DIR__ . '/plugins/'.$this->_options['pluginName'].'.php');
        $pluginClassName = 'AnimatedCaptcha_Plugin_'.$this->_options['pluginName'];
        $pluginClass = new $pluginClassName($this->_options['pluginOptions']);
        /** @var $pluginClass AnimatedCaptcha_Plugin */
        $this->_frames = $pluginClass->getFrames();
        return;
    }

    /**
     * Get a random file path in the system temp path
     */
    protected function _createTempFilePath()
    {
        $tempFilePath = tempnam('', '') . '.gif';
        $this->_tempFilePath = $tempFilePath;
        return;
    }

    /**
     * write the frames to a file depending on the output format
     */
    protected function _writeFramesToTargetFile()
    {
        $delays = array();

        for ($i=0; $i<count($this->_frames); $i++) {
            $delays[] = $this->_options['millisecondsBetweenFrames'];
        }

        $gif = new GIFEncoder($this->_frames, $delays, 0, 2, 0, 0, 0, 0, 'bin' );
        file_put_contents($this->_tempFilePath, $gif->GetAnimation());
        return;
    }
}