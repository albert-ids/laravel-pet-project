<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class ParseRssFeed extends Command
{
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Rss feed and store new posts into the database';

    public function Handle(){
        $rssUrl = 'https://lifehacker.com/rss';

        $response = Http::get($rssUrl);

        if(!$response->ok()){
            $this->error('failed to fetch RSS feed');
        }

        $rss = simplexml_load_string($response->body());

        $count = 0;

        foreach ($rss->channel->item as $item) {
            $link = (string) $item->link;

            // check if post exists
            if (Post::where('link', $link)->exists()) {
                continue;
            }

            Post::create([
                'title'       => (string) $item->title,
                'link'        => $link,
                'description' => (string) $item->description ?? null,
                'pub_date'    => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
            ]);

            $this->info("Added: " . $link);

            $count++;
        }

        $this->info("Parsed and added {$count} new posts.");
        return 0;
    }
}
