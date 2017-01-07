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
     * Rezzza\Flickr\Metadata
     *
     * @var $metadata;
     */
    private $metadata;

    /**
     * Rezzza\Flickr\ApiFactory
     *
     * @var $factory
     */
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
    }

    /**
     * Upload file to Flickr app. Clean up image on our server.
     *
     * @param string $file Location of file to upload.
     * @param string $title Title of photo
     * @return int Flickr Image ID
     * @throws Exception
     */
    public function upload($file, $title)
    {
        $response = $this->factory->upload($file, $title);

        if (!$this->isResponseSuccessful($response)) {
            throw new \Exception('Error uploading to Flickr');
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
            throw new \Exception('Error getting image sizes');
        }

        return $response->sizes->size;
    }

    /**
     * Get OAuth access token
     *
     * @param string $callback
     */
    public function authenticate($callback)
    {
        $flickr = new Flickr($this->apiKey, $this->apiSecret, $callback);
        if (!$flickr->authenticate('write')) {
            throw new \Exception('Unable to authenticate');
        }
        $accessToken = $flickr->getOauthData(Flickr::OAUTH_ACCESS_TOKEN);
        $accessTokenSecret = $flickr->getOauthData(Flickr::OAUTH_ACCESS_TOKEN_SECRET);

        $this->metadata->setOauthAccess($accessToken, $accessTokenSecret);
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
