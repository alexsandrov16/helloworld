<?php

namespace App\Commands;

use Al3x5\xBot\Commands;
use Al3x5\xBot\Telegram;
use GuzzleHttp\Client;

/**
 * undocumented class
 */
final class Movie extends Commands
{
    public function execute(): Telegram
    {
        $client = new Client();

        $this->bot->sendChatAction([
            'chat_id' => $this->bot->getChatId(),
            'action' => 'typing'
        ]);

        try {
            $response = $client->get('https://whoa.onrender.com/whoas/random');

            if ($response->getStatusCode() === 200) {
                $api = json_decode($response->getBody(), true);

                $data = $api[0];


                $this->bot->sendPhoto(
                    [
                        'chat_id' => $this->bot->getChatId(),
                        'photo' => $data['poster'],
                        'caption' => sprintf(
                            'Movie: %s
Year: %s
Director: %s',
                            $data['movie'],
                            $data['year'],
                            $data['director']
                        )
                    ]

                );

                return $this->bot->sendVideo([
                    'chat_id' => $this->bot->getChatId(),
                    'video' => $data['video']["1080p"],
                    'caption' => 'Presione /movie para buscar otra película'
                ]);
            } else {
                return $this->bot->reply('Error al llamar la API');
            }
        } catch (\Exception $e) {
            return $this->bot->reply('Error al llamar la API: ' . $e->getMessage());
        }
    }
}
