<?php
/**
 * AssetsInterface.php
 * 7/15/17 - 4:49 AM
 *
 * PHP version 7
 *
 * @package    @package_name@
 * @author     Julien Duseyau <julien.duseyau@gmail.com>
 * @copyright  2017 Julien Duseyau
 * @license    https://opensource.org/licenses/MIT
 * @version    Release: @package_version@
 *
 * The MIT License (MIT)
 *
 * Copyright (c) Julien Duseyau <julien.duseyau@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Maduser\Minimal\Assets\Contracts;


/**
 * Class Asset
 *
 * @package Maduser\Minimal\Assets
 */
interface AssetsInterface
{
    /**
     * @param $path
     */
    public function setSource($path);

    /**
     * @return string
     */
    public function getSource();

    /**
     * @param $path
     */
    public function setBase($path);

    /**
     * @return string
     */
    public function getBase();

    /**
     * @param $path
     */
    public function setTheme($path);

    /**
     * @return string
     */
    public function getTheme();

    /**
     * @param $path
     */
    public function setCssDir($path);

    /**
     * @return string
     */
    public function getCssDir();

    /**
     * @param $path
     */
    public function setJsDir($path);

    /**
     * @return string
     */
    public function getJsDir();

    /**
     * @param $path
     */
    public function setVendorDir($path);

    /**
     * @return string
     */
    public function getVendorDir();

    /**
     * @return string
     */
    public function getDefaultKey();

    /**
     * @param $defaultKey
     */
    public function setDefaultKey($defaultKey);

    /**
     * @return array
     */
    public function getCssFiles();

    /**
     * @return array
     */
    public function getJsFiles();

    /**
     * @return array
     */
    public function getVendorFiles();

    /**
     * @return string
     */
    public function getJsPath();

    /**
     * @param null $key
     *
     * @return null|string
     */
    public function key($key = null);

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     */
    public function addCss($urls, $key = null, array $attr = null);

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return
     */
    public function addJs($urls, $key = null, array $attr = null);

    /**
     * @param $url
     * @param $key
     *
     * @return mixed
     */
    public function isRegisteredJsFile($url, $key);

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return
     */
    public function addVendorCss($urls, $key = null, array $attr = null);

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return
     */
    public function addVendorJs($urls, $key = null, array $attr = null);

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getCss($key = null, $concatFilename = null);

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getVendorCss($key = null, $concatFilename = null);

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getJs($key = null, $concatFilename = null);

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public function getVendorJs($key = null, $concatFilename = null);

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return
     */
    public function addExternalCss($urls, $key = null, array $attr = null);

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalCss($key = null);

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return
     */
    public function addExternalJs($urls, $key = null, array $attr = null);

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalJs($key = null);

    /**
     * @param          $key
     * @param \Closure $inlineScript
     */
    public function addInlineScripts($key, \Closure $inlineScript);

    /**
     * @param null $key
     *
     * @return string
     */
    public function getInlineScripts($key = null);

    /**
     * @param array $cssFiles
     *
     * @return mixed
     */
    public function getCssTags(array $cssFiles);

    /**
     * @param array $jsFiles
     *
     * @return mixed
     */
    public function getJsTags(array $jsFiles);
}