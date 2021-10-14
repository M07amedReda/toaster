<?php
namespace MohamedReda\Toaster;

use Illuminate\Config\Repository as Config;
use Illuminate\Session\SessionManager as Session;

class Toaster
{
    /**
     * The Config Handler.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The messages in session.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * The session manager.
     * @var \Illuminate\Session\SessionManager
     */
    /**
     * @param Session $session
     * @param Config $config
     */
    protected $session;

    /**
     * @param Session $session
     * @param Config $config
     */
    public function __construct(Session $session, Config $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     *
     * Add a flash message to session.
     *
     * @param string $type Must be one of info, success, warning, error.
     * @param string $message The flash message content.
     * @param string $title The flash message title.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function add($type, $message, $title = null, $options = [])
    {
        $types = ['error', 'info', 'success', 'warning'];

        if (!in_array($type, $types)) {
            throw new Exception("The $type remind message is not valid.");
        }

        $this->messages[] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'options' => $options,
        ];

        $this->session->flash('message', $this->messages);
    }

    /**
     * Clear messages
     *
     * @return void
     */
    public function clear()
    {
        $this->messages = [];
    }

    /**
     * Add an error flash message to session.
     *
     * @param string $message The flash message content.
     * @param string $title The flash message title.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function error($message, $title = null, $options = [])
    {
        $this->add('error', $message, $title, $options);
    }

    /**
     * Add an info flash message to session.
     *
     * @param string $message The flash message content.
     * @param string $title The flash message title.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function info($message, $title = null, $options = [])
    {
        $this->add('info', $message, $title, $options);
    }

    /**
     * @return mixed
     */
    public function message()
    {
        $messages = $this->session->get('message');
        if (is_string($messages)) {
            $messages = [['message' => $messages, 'type' => 'info', 'title' => null, 'options' => []]];
        }
        if (is_null($messages)) {
            $messages = [];
        }

        $script = '<script type="text/javascript">';
        foreach ($messages as $message) {
            $config = (array) $this->config->get('toaster.options');

            if (count($message['options'] ?? [])) {
                $config = array_merge($config, $message['options']);
            }

            if ($config) {
                $script .= 'toastr.options = ' . json_encode($config) . ';';
            }
            $title = $message['title'];
            $type = $message['type'];
            $message = $message['message'];
            $script .= 'toastr.' . $type .
                '(\'' . $message .
                "','$title" .
                '\');';

        }

        $script .= '</script>';

        return $script;
    }

    /**
     * Add a success flash message to session.
     *
     * @param string $message The flash message content.
     * @param string $title The flash message title.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function success($message, $title = null, $options = [])
    {
        $this->add('success', $message, $title, $options);
    }

    /**
     * Add an warning flash message to session.
     *
     * @param string $message The flash message content.
     * @param string $title The flash message title.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function warning($message, $title = null, $options = [])
    {
        $this->add('warning', $message, $title, $options);
    }
}
