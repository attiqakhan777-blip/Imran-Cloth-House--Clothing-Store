<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function storeLocator()
    {
        return view('frontend.store-locator');
    }

    public function exchangeRefund()
{
    return view('frontend.exchange-refund');
}

public function terms()
{
    return view('frontend.terms');
}

public function shipping()
{
    return view('frontend.shipping-policy');
}

public function privacy()
{
    return view('frontend.privacy-policy');
}

public function faq()
{
    return view('frontend.faq');
}
}