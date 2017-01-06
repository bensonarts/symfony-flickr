<?php

namespace AppBundle\Service;

use Rezzza\Flickr\ApiFactory;
use Rezzza\Flickr\Metadata;
use Rezzza\Flickr\Http\GuzzleAdapter;

/**
 *
 */
class FlickrManager
{
    /**
     * Flickr API Key
     *
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * Flickr API Secret
     *
     * @var string $apiSecret
     */
    private $apiSecret;

    /**
     * Class constructor
     *
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Upload file to Flickr app. Clean up image on our server.
     *
     * @param string $file Location of file to upload.
     * @param string $title Title of photo
     * @return void
     */
    public function upload($file, $title)
    {
        $metadata = new Metadata($this->apiKey, $this->apiSecret);
        $metadata->setOauthAccess('access token', 'access token secret');

        $factory  = new ApiFactory($metadata, new GuzzleAdapter());

        #$xml = $factory->call('flickr.test.login');
        /*$xml = $factory->call('flickr.photos.getInfo', array(
            'photo_id' => 1337,
        ));*/

        $response = $factory->upload($file, $title);

        var_dump($response);exit;
    }


}
