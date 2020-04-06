<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConcatRequest;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Crawler\Crawler;

class MainController extends BaseController
{
    public function get()
    {
        return view('welcome');
    }

    public function post(ConcatRequest $request)
    {
        $prefix = md5(microtime());
        $ffMpegPath = "C:/Users/Example/Desktop/ffmpeg-4.2.2/bin/ffmpeg";
        $outputPath = "download/{$prefix}_output.mp4";

        $urls = array_filter($request->get('urls'));

        if (empty($urls)) {
            throw new \Exception('Empty urls');
        }

        $filePaths = [];
        $commands = [];
        $concats = [];

        foreach($urls as $url) {
            $filePaths[] = 'download/' . md5(parse_url($url)['path']) . '.mp4';

            Crawler::create([
                    'verify' => false
                ])
                ->setCrawlObserver(new \App\Modules\Tiktok\Crawler())
                ->executeJavaScript()
                ->setMaximumCrawlCount(1)
                ->startCrawling($url);
        }

        foreach ($filePaths as $index => $filePath) {
            $intermediateFilePath = "download/sub_{$prefix}_{$index}.ts";
            $concats[] = $intermediateFilePath;
            $commands[] = "$ffMpegPath -i $filePath -c copy -bsf:v h264_mp4toannexb -f mpegts $intermediateFilePath";
        }

        $concatenationsCommandString = implode('|', $concats);

        foreach ($commands as $command) {
            exec($command);
        }

        exec($ffMpegPath . ' -i "concat:' . $concatenationsCommandString . '" -c copy -bsf:a aac_adtstoasc ' . $outputPath);

        foreach ($filePaths as $index => $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            if (file_exists("download/sub_{$prefix}_{$index}.ts")) {
                unlink("download/sub_{$prefix}_{$index}.ts");
            }
        }

        if (file_exists($outputPath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($outputPath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($outputPath));
            readfile($outputPath);
            exit;
        }

        return response()->json([
            'urls' => $request->get('urls'),
            'output' => $outputPath
        ]);
    }
}
