<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSearchGoogle;
use App\Models\Proxy;
use Dachoagit\Search\Facade\SearchGoogle;
use Illuminate\Http\Request;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class TestController extends Controller
{
    public function index(){


    }
}
