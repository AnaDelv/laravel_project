<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    /**
     * Create a new controller instance.
     * User must be logged in to access these pages
     * @return void
     * author: A. Delavau
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Control the index page
     *
     * @return $this
     *
     * authors: Y.Merle (queries & slides) & A. Delavau (Laravel conversions)
     */

    public function index()
    {

        $data = [
            'title' => 'Welcome !',
            'news' => DB::table('news')
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get(),
        ];
        return view('pages.index')->with($data);
    }

    /**
     * Control the dashboard page
     *
     * @return $this
     *
     * author: A. Delavau
     */

    public function dashboard()
    {
        $data = [
            'title' => "Panneau de contrôle",
            'list_lp' => DB::table('classes_list')->select('name')->where('etablissement', '=', 'LP')->get(),
            'list_lg' => DB::table('classes_list')->select('name')->where('etablissement', '=', 'LG')->get()];

        return view('pages.dashboard')->with($data);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function agenda()
    {
        return view('pages.agenda');
    }

}