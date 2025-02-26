<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class ScrapeCommand extends Command
{
    protected $signature = 'scrape:run {--url=}';
    protected $description = 'Uruchamia scraper';

    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $client = new Client(['cookies' => true]);
        $response = $client->get('https://jbzd.com.pl/nsfw');
//        if($response->)
        if ($response->getStatusCode() !== 200) {
            $this->error('Błąd pobierania strony');
            return;
        }

        $crawler = new Crawler((string) $response->getBody());
        $links = $crawler->filter('#content-container .article .article-content .article-title a')->each(fn($node) => $node->attr('href'));

        file_put_contents('links.txt', implode(PHP_EOL, $links) . PHP_EOL, FILE_APPEND);
        $this->info('Zapisano linki!');
    }
}
