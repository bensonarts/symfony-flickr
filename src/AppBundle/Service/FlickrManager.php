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

    private $metadata;

    private $factory;

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
        $this->metadata = new Metadata($this->apiKey, $this->apiSecret);
        $this->authenticate();
    }

    /**
     * Upload file to Flickr app. Clean up image on our server.
     *
     * @param string $file Location of file to upload.
     * @param string $title Title of photo
     * @param string $callback
     * @return int Flickr Image ID
     * @throws Exception
     */
    public function upload($file, $title, $callback)
    {
        /*
        $flickr = new Flickr($this->apiKey, $this->apiSecret, null);
        if (!$flickr->authenticate('write')) {
            // some problem!
        }

        $response = $flickr->upload([
            'title' => $title,
            'photo' => '@'. realpath($file),
        ]);

        var_dump($response);exit;
        */


        $response = $this->factory->upload($file, $title);

        if (!$this->isResponseSuccessful($response)) {
            throw \Exception('Error uploading to Flickr');
        }

        return $response->photoid;
    }

    /**
     * Get image sizes
     *
     * @param int $imageId
     * @return array
     * @throws Exception
     */
    public function getImageSizes($imageId) {
        $response = $this->factory->call('flickr.photos.getSizes', [
            'photo_id' => $imageId,
        ]);

        if (!$this->isResponseSuccessful($response)) {
            throw \Exception('Error uploading to Flickr');
        }

        return $response->sizes->size;
    }

    /**
     * Get OAuth access token
     */
    protected function authenticate()
    {
        // TODO
        $this->metadata->setOauthAccess('72157675114822233-daeff6d72bbd5273', 'c13adc30b5163ac0');
        $this->factory = new ApiFactory($this->metadata, new GuzzleAdapter());
    }

    /**
     * Validate response for success
     *
     * @param array $response
     * @return boolean
     */
    protected function isResponseSuccessful($response)
    {
        return $response && isset($response['stat']) && $response['stat'] == 'ok';
    }

}
