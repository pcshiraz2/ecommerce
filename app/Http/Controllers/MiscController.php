<?php

namespace App\Http\Controllers;


class MiscController extends Controller
{
    public function setPerPage($limit)
    {
        session(['per-page' => $limit]);
        flash('هم اکنون شما در هر صفحه ' . $limit . ' مورد را مشاهده خواهید کرد.')->info();
        return redirect()->back();
    }
}
