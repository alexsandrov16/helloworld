<?php

namespace Al3x5\xBot;

use Al3x5\xBot\Exceptions\xBotException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

/**
 * Telegram class
 */
class Telegram
{
    private ?Client $client = null;
    private ?ResponseInterface $response = null;
    private const METHODS = [
        //cli commands
        'getMe',
        'setWebhook',
        'deleteWebhook',
        'getWebhookInfo', 
        //Informativos
        'getChatMember', //Usuarios miembros
        'getChatAdministrators', //Administradores
        'getChatMembersCount', //Conteo de usuarios
        'getChat', //Información de chat
        'getChatHistory', //Historial de chat
        'getChatMembers', //Lista de usuarios

        'sendMessage',
        'forwardMessage',
        'forwardMessages',
        'copyMessage',
        'sendPhoto',
        'sendAudio',
        'sendDocument',
        'sendVideo',
        'sendAnimation',
        'sendPoll',
        'sendDice',
        'sendSticker',
        'editMessageText',

        'sendChatAction', //Estado
    ];

    public function __construct(private string $method, private array $params)
    {

        if ($this->has($method) == false) {
            throw new xBotException("Method '$method' not found");
        }

        $this->client = new Client();

        $params['parse_mode'] = Config::get('parse_mode');

        $this->method = $method;
        $this->params = $params;
    }

    public function __toString()
    {
        $body = json_decode($this->response->getBody(), true);

        if (in_array($this->method, ['getMe', 'getWebhookInfo'])) {

            $output = '';

            foreach ($body['result'] as $key => $value) {
                $output .= "$key: $value" . PHP_EOL;
            }

            return $output;
        }

        if (in_array($this->method, ['setWebhook', 'deleteWebhook'])) {
            return $body['description'] . PHP_EOL;
        }
    }

    /**
     * Verifica existencia del metodo telegram api
     */
    public function has(string $name): bool
    {
        return in_array($name, static::METHODS);
    }

    /**
     * Envia el metodo
     */
    public function send(): Telegram
    {
        try {
            $this->response = $this->client->post(
                Config::get('webhook') . $this->method,
                [
                    'form_params' => $this->params
                ]
            );

            if ($this->response->getStatusCode() !== 200) {
                throw new xBotException("Server response error");
            }
            return $this;
        } catch (ClientException $e) {
            Events::logger(
                'TelegramApi',
                date('Ymd') . '.log',
                $e->getMessage() . '' . $e->getTraceAsString(),
                ['code' => $e->getCode()],
                'warning'
            );
        }
    }
}
