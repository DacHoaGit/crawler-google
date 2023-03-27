<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Library\Widget;
use Dachoagit\Search\KeyWord;
use Dachoagit\Search\Models\LogProxy;
use Dachoagit\Search\Models\Proxy;
use SpiderAutoCrawl\BaseCore\Enums\ProxyStatusEnum;
use SpiderAutoCrawl\BaseCore\Enums\ResultStatusEnum;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class TestController extends Controller
{

    public function index()
    {

        Widget::add([ 
            'type'       => 'chart',
            'controller' => \App\Http\Controllers\Admin\Charts\LogProxiesChartController::class,
            'data' => [
                'id' => 114
            ],
            // OPTIONALS
        
            // 'class'   => 'card mb-2',
            'wrapper' => ['class'=> 'w-100'] ,
            // 'content' => [
                 // 'header' => 'New Users', 
                 // 'body'   => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>',
            // ],
        ]);
        dd(1);
        // cutom logic after






//         $client = HttpClient::create([
//             'proxy' => "http://gbhpbkso:qvl3t928e551@45.67.0.230:6666",
//             'timeout' => 10
//         ]);

//         $response = $client->request(
//             'GET',
//             'https://www.google.com/search?q=' . urlencode("Diversatek") . '&start=1',
//             [
//                 'headers' => [
//                     "User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit 537.36 (KHTML, like Gecko) Chrome",
//                 ]
//             ]
//         );
// //        echo $response->getContent();
//         $crawler = new Crawler($response->getContent());
//         $link = $crawler->filterXpath('//*[@id="main"]/div/div/div/div[1]/div')->filter('a')->extract(['href']);
//         dd($link);










//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_PROXY, 'http://gbhpbkso:qvl3t928e551@156.238.9.209:7100');
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/search?q=' . urlencode('ConsultNet') . '&start=1');
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5)\
//            AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36",
//        ]);
//        $data = curl_exec($ch);
//        curl_close($ch);
//        echo $data;


//        $http = HttpClient::create([
//            'proxy' => 'http://gbhpbkso:qvl3t928e551@156.238.9.209:7100',
//            'timeout' => 10
//        ]);

//        $response = $http->request(
//            'GET',
//            'https://www.google.com',
//            [
//                'headers' => [
//                    "User-Agent"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5)\AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36",
//                ]
//            ]
//        );
//
//        $response = $http->request(
//            'GET',
//            'https://www.google.com/search?q=' . urlencode('ConsultNet') . '&start=1',
//            [
//                'headers' => [
//                    "User-Agent"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5)\AppleWebKit/537.36 (KHTML, like Gecko) Cafari/537.36",
//                ]
//            ]
//        );
//        echo ($response->getContent());
//
//        $crawler = new Crawler($response->getContent());
//        $crawlers = $crawler->filterXpath('//*[@id="main"]/div/div/div/div[1]/div')->filter('a')->extract(['href']);
//
//        foreach ($crawlers as $result) {
//            $temp = explode("q=", $result)[1];
//            $temp = (explode("&sa", $temp)[0]);
//
//            array_push($this->links, $temp);
//        }
//
//        echo($response->getContent());


//        $user_again = \Campo\UserAgent::random([
//            'agent_name' => ['Chrome'],
//        ]);
//        $user_again = explode(" AppleWebKit",$user_again)[0];

    }

}

