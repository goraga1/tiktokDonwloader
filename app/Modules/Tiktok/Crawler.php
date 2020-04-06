<?php

namespace App\Modules\Tiktok;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class Crawler extends \Spatie\Crawler\CrawlObserver
{

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(UriInterface $url,
                            ResponseInterface $response,
                            ?UriInterface $foundOnUrl = null)
    {
        $name = md5($url->getPath());
        foreach(str_get_html($response->getBody()->getContents())->find('video') as $source) {

            if (isset($source->attr['src'])) {
                $videoUrl = $source->attr['src'];
                break;
            }
        }

        $path = "download/$name.mp4";

        if(! file_exists($path)) {
            copy($videoUrl, $path);
        }
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(UriInterface $url,
                                RequestException $requestException,
                                ?UriInterface $foundOnUrl = null)
    {
        dd($requestException);

        // TODO: Implement crawlFailed() method.
    }
}