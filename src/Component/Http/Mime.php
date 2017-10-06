<?php
/**
 * The Opera Framework
 * Mime.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http;



class Mime
{

    const TEXT_PLAIN = 'text/plain';

    const TEXT_HTML = 'text/html';

    const TEXT_CSS = 'text/css';

    const TEXT_JAVASCRIPT = 'text/javascript';

    const APPLICATION_JSON = 'application/json';
    const APPLICATION_PDF = 'application/pdf';
    const APPLICATION_OCTET_STREAM = 'application/octet-stream';

    private static $extensions = [
        'txt'   => Mime::TEXT_PLAIN,
        'html'  => Mime::TEXT_HTML,
        'phtml' => Mime::TEXT_HTML,
        'css'   => Mime::TEXT_CSS,
        'less'  => Mime::TEXT_CSS,
        'js'    => Mime::TEXT_JAVASCRIPT,

        'pdf'   => Mime::APPLICATION_PDF,
    ];

    /**
     * Returns a mime type based on the given extension
     * if no mime type could be found the mime type
     * application/octet-stream is returned
     *
     * @param string $extension
     *
     * @return string
     */
    public static function fromExtension(string $extension) : string
    {
        return self::$extensions[$extension] ?? self::APPLICATION_OCTET_STREAM;
    }
}