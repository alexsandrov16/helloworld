<?php

namespace App\Commands;

use Al3x5\xBot\Commands;
use Al3x5\xBot\Telegram;

/**
 * undocumented class
 */
final class Start extends Commands
{
    public function execute(): Telegram
    {
        $this->bot->reply(
            sprintf(
                'Hola @%s, soy un bot de prueba',
                $this->message->get('from')->username
            )
        );
        return $this->bot->reply('Ejecuta el comando /movie para ver una película');
    }
}
