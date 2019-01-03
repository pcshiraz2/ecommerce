<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 3/30/2018
 * Time: 5:52 PM
 */

namespace App\Channels;


class TextMessage
{
    public $payload = [];

    public function __construct($content = '')
    {
        $this->content($content);
    }

    public static function create($content = '')
    {
        return new static($content);
    }

    public function to($mobile)
    {
        $this->payload['mobile'] = $mobile;
        return $this;
    }

    public function content($content)
    {
        $this->payload['text'] = $content;
        return $this;
    }

    public function link($link)
    {
        $this->payload['link'] = $link;
        return $this;
    }

    public function toNotGiven()
    {
        return !isset($this->payload['mobile']);
    }

    public function toArray()
    {
        return $this->payload;
    }
}