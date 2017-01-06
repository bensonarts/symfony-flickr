<?php

/**
 *
 */
class FlickrManager
{
    /**
     * Flickr Client
     *
     * @var $flickrClient
     */
    private $flickrClient;

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
     * @param $flickrClient
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($flickrClient, $apiKey, $apiSecret)
    {
        $this->flickrClient = $flickrClient;
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
        $this->flickrClient->getMetadata()->setOauthAccess('access token', 'access token secret');

        #$factory  = new Rezzza\Flickr\ApiFactory($metadata, new Rezzza\Flickr\Http\GuzzleAdapter());

        $this->flickrClient->call('flickr.test.login');
        $this->flickrClient->call('flickr.photos.getInfo', [
            'photo_id' => 1337,
        ]);

        $this->flickrClient->upload($file, $title);
    }


}
