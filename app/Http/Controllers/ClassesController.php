<?php

namespace App\Http\Controllers;

use App\ClassList;
use Illuminate\Http\Request;
use DB;

class ClassesController extends Controller
{

    /**
     * Create a new controller instance.
     * User must be logged in to access these pages
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = \Request::get('search');

        if ($query)
        {
            $list = DB::table('classes_list')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('etablissement', 'LIKE', '%' .$query . '%')
                ->orderBy('name')
                ->paginate(10);

        }
        else
        {
            $list = DB::table('classes_list')->paginate(5);
        }

        return view('class.index')->with('list', $list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'choice' => 'required'
        ]);

        DB::table('classes_list')
            ->insert(['name' => $request->input('name'),
                'etablissement' => $request->input('choice') ]);

        return redirect('/classes')->with('success', 'Classe ajoutée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = DB::table('classes_list')->find($id);
        return view('class.edit')->with('class', $class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:50',
        ]);
        DB::table('classes_list')->where('id', $id)->update(['name' => $request->input('name')]);
        return redirect('/classes')->with('success', 'Classe modifiée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('classes_list')->delete($id);
        return redirect('/classes')->with('success', 'Classe supprimée');
    }
}
