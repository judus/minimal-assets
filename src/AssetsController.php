<?php

namespace Maduser\Minimal\Assets;

use Maduser\Minimal\Config\Exceptions\KeyDoesNotExistException;
use Maduser\Minimal\Modules\Contracts\ModulesInterface;
use Maduser\Minimal\Assets\Contracts\AssetsInterface;
use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Http\Contracts\RequestInterface;
use Maduser\Minimal\Http\Contracts\ResponseInterface;
use Maduser\Minimal\Routing\Contracts\RouterInterface;
use Maduser\Minimal\Views\Contracts\ViewInterface;

class AssetsController
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * AssetsController constructor.
     *
     * @param ConfigInterface   $config
     * @param ResponseInterface $response
     */
    public function __construct(
        ConfigInterface $config,
        ResponseInterface $response
    ) {
        /** @var \Maduser\Minimal\Config\Config $config */
        /** @var \Maduser\Minimal\Http\Response $response */
        $this->config = $config;
        $this->response = $response;
    }

    /**
     * @param $alias
     * @param $path
     *
     * @return string
     */
    public function serve($alias, $path)
    {
        $filePath = '';

        try {
            $filePath = $this->config->item('assets.routes.' . $alias) . '/' . $path;
        } catch (KeyDoesNotExistException $e) {
            $this->response->status404();
        }

        if (!file_exists($filePath)) {
            $this->response->status404();
        }

        ob_start();

        $fileName = basename($filePath);
        $fileSize = filesize($filePath);
        $fileTime = filemtime($filePath);
        $fileType = $this->mimeContentType($filePath);
        $maxAge = (60 * 60 * 24 * 30);
        $expires = date('r', $fileTime + $maxAge);
        $lastModified = date('r', $fileTime);

        $this->response->header('Pragma: public'); // required
        $this->response->header('Cache-Control: public, must-revalidate, proxy-revalidate, max-age="' . $maxAge . '", s-maxage="' . $maxAge . '"');
        $this->response->header('Last-Modified: ' . $lastModified);
        $this->response->header('Expires: ' . $expires);
        $this->response->header('Content-Type: ' . $fileType);
        $this->response->header('Content-Disposition: inline; filename="' . $fileName . '";');
        $this->response->header('Content-Transfer-Encoding: binary');
        $this->response->header('Content-Length: ' . $fileSize);

        readfile($filePath);

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * @param $filename
     *
     * @return mixed|string
     */
    protected function mimeContentType($filename)
    {
        $mimeTypes = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $ext = strtolower(pathinfo($filename)['extension']);

        if (array_key_exists($ext, $mimeTypes)) {
            return $mimeTypes[$ext];
        }

        return 'application/octet-stream';
    }

}