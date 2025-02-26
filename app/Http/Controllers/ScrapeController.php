<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class ScrapeController extends Controller
{
    public function scrape(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|string|url',
        ], [
            'url.required' => 'Pole URL jest wymagane.',
            'url.string' => 'URL musi być ciągiem znaków.',
            'url.url' => 'Podaj poprawny adres URL.',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $url = $request->get('url');
        $phpBinary = (new PhpExecutableFinder())->find();
        $command = "$phpBinary artisan scrape:run --url=$url > /dev/null 2>&1 &";
        (new Process([$command], null, null, null, null))->run();
        return response()->json(['status' => 'Scraper started']);
    }

    public function status()
    {
        $running = shell_exec("ps aux | grep 'artisan scrape:run' | grep -v grep");
        return response()->json(['running' => !empty($running), 'r' => $running]);
    }
}
