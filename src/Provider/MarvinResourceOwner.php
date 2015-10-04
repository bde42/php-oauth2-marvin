<?php namespace BDE42\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MarvinResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected $data;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->data = $response;
    }

    /**
     * Get user id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getField('id');
    }

    /**
     * Get user details as an array.
     *
     * @return array[uid, email, name, login]
     */
    public function getUserInfos()
    {
        return ['uid' => $this->getId(),
                'email' => $this->getField('email'),
                'name' => $this->getField('displayname'),
                'login' => $this->getField('login')
                ];
    }
    
    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
    
    private function getField($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
