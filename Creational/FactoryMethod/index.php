<?php

abstract class Creator
{
    /**
     * @return SocialNetworkConnector
     */
    abstract public function getSocialNetwork(): SocialNetworkConnector;

    /**
     * @param string $content
     * @return void
     */
    public function post(string $content)
    {
        $social_network = $this->getSocialNetwork();
        $social_network->login();
        $social_network->createPost($content);
        $social_network->logout();
    }
}

class FacebookPoster extends Creator
{

    public function __construct(private readonly string $login, private readonly string $password)
    {
    }

    /**
     * @return SocialNetworkConnector
     */
    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}

interface SocialNetworkConnector
{
    public function login();
    public function logout();

    /**
     * @param string $content
     * @return void
     */
    public function createPost(string $content);
}

class FacebookConnector implements SocialNetworkConnector
{
    public function __construct(private readonly string $login, private readonly string $password)
    {
    }
    /**
     * @return mixed
     */
    public function login()
    {
        echo "Send HTTP API request to log in user $this->login with " .
            "password $this->password\n";
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        echo "Send HTTP API request to log out user $this->login\n";
    }

    /**
     *
     * @param string $content
     * @return void
     */
    public function createPost(string $content)
    {
        echo $content . PHP_EOL;
    }
}

function clientCode(Creator $creator)
{
    $creator->post('Test');
}

clientCode(new FacebookPoster('admin123', 'admin123'));
