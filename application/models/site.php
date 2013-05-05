<?php

class Site extends Aware
{
    public static $timestamps = TRUE;

    /**
     * Simple validation rules for the model.
     * @var array
     */
    public static $rules = array(
        'domain' => 'required|unique:sites',
        'protocol' => 'in:http,https',
    );

    public static $messages = array(
        'domain_unique' => 'A site with this domain has already been created. If you own this domain and would like to dispute this, please contact us.',
    );

    public function parse_url($url)
    {
        $matches = array();
        if (preg_match("@^(https?)://(.+)@", $url, $matches)) {
            $this->protocol = $matches[1];
            $this->domain = $matches[2];
        } else {
            throw new Exception("Invalid URL");
        }
    }

    public function get_url($path = '')
    {
        if ($path && substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return sprintf("%s://%s%s", $this->protocol, $this->domain, $path);
    }

    /**
     * Relationships.
     */
    public function user()
    {
        return $this->belongs_to('User');
    }

    public function tests()
    {
        return $this->has_many('Test');
    }
}