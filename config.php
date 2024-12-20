<?php
return [
    'token' => getenv('TELEGRAM_BOT_TOKEN'),
    'name' => 'woah',
    'admins' => [],
    'storage' => \Mk4U\Cache\CacheFactory::create('file', ['dir' => 'storage/cache', 'ttl' => 5]),
    //'webhook'=> 'https://YOUR_WEBHOOK_URL,
    //'webhook_secret' => 'YOUR_WEBHOOK_SECRET',
    //'db'=>'sqlite:xbot.db',
    'dev' => false,
    'logs' => 'storage/logs', //LOGS DIR
    'parse_mode'=>'MarkdownV2',
    'handler' => [
        //NAMESPACES COMMANDS
        //'/start' => \App\Commands\StartCommand::class,
        '/start'=>\App\Commands\Start::class,
        '/movie'=>\App\Commands\Movie::class,
    ]
];