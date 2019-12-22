<?php

namespace Andremellow\Comtele\Messages;

class ComteleMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Message reference sent to the API.
     *
     * @var string
     */
    private $sender;

    
    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '', $sender = '')
    {
        $this->content = $content;
        $this->sender = $sender;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the message sender.
     *
     * @param  string  $sender
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the message sender.
     *
     * @param  string  $sender
     * @return $this
     */
    public function getSender()
    {
        return $this->sender;
    }

    
}
