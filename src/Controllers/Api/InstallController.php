<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstallController extends Controller
{
    public function index(CoreRequest $request)
    {
        $html = 'instal.index';
        return $html;
    }
}
