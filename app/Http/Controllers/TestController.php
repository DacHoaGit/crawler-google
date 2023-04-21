<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Backpack\CRUD\app\Library\Widget;
use Campo\UserAgent;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Dachoagit\Search\Models\LogProxy;
use Dachoagit\Search\Models\Proxy;
use Dachoagit\Search\SearchKeyWord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use RankKeyword\RankKeywordCore\Models\Keyword;
use RankKeyWord\RankKeyWordCore\Models\KeywordType;
use RankKeyword\RankKeywordCore\Services\RankKeyword;
use SpiderAutoCrawl\BaseCore\Enums\ProxyStatusEnum;
use SpiderAutoCrawl\BaseCore\Enums\ResultStatusEnum;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class TestController extends Controller
{

    public function index()
    {

        $search = new SearchKeyWord();
        $result = $search->search('123k=job');
        dd($result);


        
        // $rank = new RankKeyword();
        // $keyword = Keyword::where('id',1)->first();
        // dd($rank->getRank($keyword));
        // $keyword = "Nhân viên Chăm sóc khách hàng";
        // $page = 1;
        // $response = HttpClient::create()->request(
        //     'GET',
        //     'https://www.google.com/search?q=' . urlencode($keyword). '&start=' . $page ."&num=100",
        //     [
        //         'headers' => [
        //             "Referer" => "https://www.google.com/",
        //         ]
        //     ]
        // );

        // $crawler = new Crawler($response->getContent());
        // dd($crawler);
        // $link = $crawler->filterXpath('//*[@class="egMi0 kCrYT"]')->filter('a')->extract(['href']);
        // // $link = array_filter($link, function ($item) {
        // //     return (strpos($item, "http") === 0);
        // // });
        // dd($link);
        // dd(1);



        $user_again = UserAgent::random([
            'agent_name' => ['Chrome'],
        ]);
        while (strpos($user_again, 'android') !== false) {
            $user_again = UserAgent::random([
                'agent_name' => ['Chrome'],
            ]);
        }

        $user_again = explode(" AppleWebKit", $user_again)[0];

        $response = HttpClient::create()->request(
            'GET',
            'https://www.' . (isset($domain) ? $domain : 'google.com') . '/search?q=' . urlencode('Lập trình viên - IT') . '&start=1&tbs=ctr:countryVN&cr=countryVN&num=100',
            [
                'headers' => [
                    "User-Agent" => $user_again . " AppleWebKit 537.36 (KHTML, like Gecko) Chrome",
                    "Referer" => "https://www.google.com/",
                ]
            ]
        );

        $crawler = new Crawler($response->getContent());
        $links = $crawler->filterXpath('//*[@id="main"]/div/div/div/div[1]/div')->filter('a')->extract(['href']);
        $links = array_filter($links, function ($item) {
            return (strpos($item, "http") === 0);
        });
        $domains = array(); // Mảng trung gian để lưu trữ các domain
        foreach ($links as $link) {
            $domain = parse_url($link, PHP_URL_HOST);
            $domains[] = $domain; // Thêm domain vào mảng trung gian
        }

        $unique_domains = array_unique($domains); // Loại bỏ các phần tử trùng lặp
        dd($unique_domains); // In ra danh sách các domain
    }
}
