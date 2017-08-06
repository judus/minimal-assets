<?php namespace Maduser\Minimal\Assets;

use Maduser\Minimal\Assets\Contracts\AssetsInterface;

/**
 * Class Asset
 *
 * @package Maduser\Minimal\Libraries\Assets
 */
class Assets implements AssetsInterface
{
    /**
     * @var string
     */
    private $source = '';

    /**
     * @var string
     */
    private $base = '';

    /**
     * @var string
     */
    private $theme = '';

    /**
     * @var string
     */
    private $cssDir = 'css';

    /**
     * @var string
     */
    private $vendorDir = 'vendor';

    /**
     * @var string
     */
    private $jsDir = 'js';

    /**
     * @var string
     */
    private $defaultKey = 'default';

    /**
     * @var array
     */
    private $cssFiles = [];

    /**
     * @var array
     */
    private $cssSourceFiles = [];

    /**
     * @var array
     */
    private $jsFiles = [];

    /**
     * @var array
     */
    private $jsSourceFiles = [];

    /**
     * @var array
     */
    private $vendorCssFiles = [];

    /**
     * @var array
     */
    private $vendorCssSourceFiles = [];

    /**
     * @var array
     */
    private $vendorJsFiles = [];

    /**
     * @var array
     */
    private $vendorJsSourceFiles = [];

    /**
     * @var array
     */
    private $inlineScripts = [];

    /**
     * @var array
     */
    private $externalCss = [];

    /**
     * @var array
     */
    private $externalJs = [];
    private $vendorFiles;

    /**
     * @param $path
     */
    public function setSource($path)
    {
        $this->source = $path;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        $source = rtrim($this->source, '/') . '/';
        return $source;
    }

    /**
     * @param $path
     */
    public function setBase($path)
    {
        $this->base = $path;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        $base = rtrim($this->base, '/') . '/';
        //$base = '/' . ltrim($base, '/');
        return $base;
    }

    /**
     * @param $path
     */
    public function setTheme($path)
    {
        $this->theme = $path;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        $this->theme = empty($this->theme) ? '' : rtrim($this->theme, '/') . '/';
        return $this->theme;
    }

    /**
     * @param $path
     */
    public function setCssDir($path)
    {
        $this->cssDir = $path;
    }

    /**
     * @return string
     */
    public function getCssDir()
    {
        return rtrim($this->cssDir, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setJsDir($path)
    {
        $this->jsDir = $path;
    }

    /**
     * @return string
     */
    public function getJsDir()
    {
        return rtrim($this->jsDir, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setVendorDir($path)
    {
        $this->vendorDir = $path;
    }

    /**
     * @return string
     */
    public function getVendorDir()
    {
        return rtrim($this->vendorDir, '/') . '/';
    }

    /**
     * @return string
     */
    public function getDefaultKey()
    {
        return $this->defaultKey;
    }

    /**
     * @param $defaultKey
     */
    public function setDefaultKey($defaultKey)
    {
        $this->defaultKey = $defaultKey;
    }

    /**
     * @return array
     */
    public function getCssFiles()
    {
        return $this->cssFiles;
    }

    /**
     * @return array
     */
    public function getJsFiles()
    {
        return $this->jsFiles;
    }

    /**
     * @return array
     */
    public function getVendorFiles()
    {
        return $this->vendorFiles;
    }

    /**
     * @return string
     */
    public function getJsPath()
    {
        return $this->getBase() . $this->getTheme() . $this->getJsDir();
    }

    /**
     * @param null $key
     *
     * @return null|string
     */
    public function key($key = null)
    {
        return $key ? $key : $this->getDefaultKey();
    }

    /**
     * Asset constructor.
     */
    public function __construct()
    {
        $this->cssFiles[$this->key()] = [];
        $this->jsFiles[$this->key()] = [];
        $this->vendorFiles[$this->key()] = [];
        $this->externalJs[$this->key()] = [];
        $this->inlineScripts[$this->key()] = [];
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addCss($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addCss($url, $key, $attr);
            }
        }

        if (is_string($urls)) {
            $this->cssFiles[$this->key($key)][] = [
                $this->getBase() . $this->getTheme() . $this->getCssDir() . $urls,
                $attr
            ];

            $this->cssSourceFiles[$this->key($key)][] = [
                $this->getSource() . $this->getTheme() . $this->getCssDir() . $urls,
                $attr
            ];
        }
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addJs($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addJs($url, $key, $attr);
            }
        }

        if (is_string($urls)) {

            if (!$this->isRegisteredJsFile($urls, $key)) {

                $this->jsFiles[$this->key($key)][] = [
                    $this->getBase() . $this->getTheme() . $this->getJsDir() . $urls,
                    $attr
                ];

                $this->jsSourceFiles[$this->key($key)][] = [
                    $this->getSource() . $this->getTheme() . $this->getJsDir() . $urls,
                    $attr
                ];
            }
        }
    }

    public function isRegisteredJsFile($url, $key)
    {
        if (isset($this->jsFiles[$this->key($key)])) {
            foreach ($this->jsFiles[$this->key($key)] as $jsFileArray) {
                if ($jsFileArray[0] == $this->getBase() . $this->getTheme() . $this->getJsDir() . $url) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addVendorCss($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addVendorCss($url, $key, $attr);
            }
        }

        if (is_string($urls)) {
            $this->vendorCssFiles[$this->key($key)][] = [
                $this->getBase() . $this->getTheme() . $this->getVendorDir() . $urls,
                $attr
            ];

            $this->vendorCssSourceFiles[$this->key($key)][] = [
                $this->getSource() . $this->getTheme() . $this->getVendorDir() . $urls,
                $attr
            ];
        }
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addVendorJs($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addVendorJs($url, $key, $attr);
            }
        }

        if (is_string($urls)) {
            $this->vendorJsFiles[$this->key($key)][] = [
                $this->getBase() . $this->getTheme() . $this->getVendorDir() . $urls,
                $attr
            ];

            $this->vendorJsSourceFiles[$this->key($key)][] = [
                $this->getSource() . $this->getTheme() . $this->getVendorDir() . $urls,
                $attr
            ];
        }
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getCss($key = null, $concatFilename = null)
    {
        if (!isset($this->cssFiles[$this->key($key)])
            || count($this->cssFiles[$this->key($key)]) == 0
        ) {
            return null;
        }

        if ($concatFilename) {
            $publicPath = $this->concat(
                $this->cssSourceFiles[$this->key($key)],
                $this->getCssDir(),
                $concatFilename
            );

            if ($publicPath) {
                return '<link rel="stylesheet" href="' . $publicPath . '">' . "\n";
            }
        }

        return $this->getCssTags($this->cssFiles[$this->key($key)]);
    }


    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getVendorCss($key = null, $concatFilename = null)
    {
        if (!isset($this->vendorCssFiles[$this->key($key)])
            || count($this->vendorCssFiles[$this->key($key)]) == 0
        ) {
            return null;
        }

        if ($concatFilename) {
            $publicPath = $this->concat(
                $this->vendorCssSourceFiles[$this->key($key)],
                $this->getVendorDir(),
                $concatFilename
            );

            if ($publicPath) {
                return '<link rel="stylesheet" href="' . $publicPath . '">' . "\n";
            }
        }

        return $this->getCssTags($this->vendorCssFiles[$this->key($key)]);
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getJs($key = null, $concatFilename = null)
    {
        if (!isset($this->jsFiles[$this->key($key)])
            || count($this->jsFiles[$this->key($key)]) == 0
        ) {
            return null;
        }

        if ($concatFilename) {
            $publicPath = $this->concat(
                $this->jsSourceFiles[$this->key($key)],
                $this->getJsDir(),
                $concatFilename
            );

            if ($publicPath) {
                return '<script type="text/javascript" src="' . $publicPath . '" ></script>' . "\n";
            }
        }

        return $this->getJsTags($this->jsFiles[$this->key($key)]);
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getVendorJs($key = null, $concatFilename = null)
    {
        if (!isset($this->vendorJsFiles[$this->key($key)])
            || count($this->vendorJsFiles[$this->key($key)]) == 0
        ) {
            return null;
        }

        if ($concatFilename) {
            $publicPath = $this->concat(
                $this->vendorJsSourceFiles[$this->key($key)],
                $this->getVendorDir(),
                $concatFilename
            );

            if ($publicPath) {
                return '<script type="text/javascript" src="' . $publicPath . '" ></script>' . "\n";
            }
        }

        return $this->getJsTags($this->vendorJsFiles[$this->key($key)]);
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addExternalCss($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addExternalCss($url, $key, $attr);
            }
        }

        if (is_string($urls)) {
            $this->externalCss[$this->key($key)][] = [$urls, $attr];
        }
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalCss($key = null)
    {
        if (isset($this->externalCss[$this->key($key)])) {
            $externalCss = $this->externalCss[$this->key($key)];
            return $this->getCssTags($externalCss);
        }

        return null;
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addExternalJs($urls, $key = null, array $attr = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addExternalJs($url, $key, $attr);
            }
        }

        if (is_string($urls)) {
            $this->externalJs[$this->key($key)][] = [$urls, $attr];
        }
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalJs($key = null)
    {
        if (isset($this->externalJs[$this->key($key)])) {
            $externalJs = $this->externalJs[$this->key($key)];
            return $this->getJsTags($externalJs);
        }

        return null;
    }

    /**
     * @param          $key
     * @param \Closure $inlineScript
     */
    public function addInlineScripts($key, \Closure $inlineScript)
    {
        $this->inlineScripts[$this->key($key)][] = $inlineScript();
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getInlineScripts($key = null)
    {
        if (isset($this->inlineScripts[$this->key($key)])) {
            $inlineScripts = $this->inlineScripts[$this->key($key)];
            $html = '';
            foreach ($inlineScripts as $inlineScript) {
                $html = empty($html) ? $html : $html . "\t";
                $html .= $inlineScript . "\n";
            }

            return $html;
        }

        return null;
    }

    public function getCssTags(array $cssFiles)
    {
        $html = '';
        foreach ($cssFiles as $cssFile) {
            $attr = '';

            if (isset($cssFile[1]) && count($cssFile[1]) > 0) {
                foreach ($cssFile[1] as $key => $value) {
                    $attr .= ' '.$key . '="'.$value.'"';
                }
            }

            $html = empty($html) ? $html : $html . "\t";
            $html .= '<link rel="stylesheet" href="' . $cssFile[0] . '"'.$attr.'>' . "\n";
        }

        return $html;
    }

    public function getJsTags(array $jsFiles)
    {
        $html = '';
        foreach ($jsFiles as $jsFile) {
            $attr = '';
            if (isset($jsFile[1]) && count($jsFile[1]) > 0) {
                foreach ($jsFile[1] as $key => $value) {
                    $attr .= ' ' . $key . '="' . $value . '"';
                }
            }

            $html = empty($html) ? $html : $html . "\t";
            $html .= '<script type="text/javascript" src="' . $jsFile[0] . '"'.$attr.'></script>' . "\n";
        }

        return $html;
    }


    protected function concat($files, $dirname, $filename)
    {
        $contents = '';

        foreach ($files as $file) {
            if (file_exists($file)) {
                ob_start();
                readfile($file);
                $contents .= ob_get_contents();
                ob_end_clean();
            }
        }

        if (!empty($contents)) {
            $sourcePath = $this->getSource() . $this->getTheme() . $dirname . $filename;
            $publicPath = $this->getBase() . $this->getTheme() . $dirname . $filename;

            file_put_contents($sourcePath, $contents);

            return $publicPath;

        }

        return null;
    }


}