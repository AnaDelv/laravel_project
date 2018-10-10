<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Filesystem\Filesystem;

class FilesController extends Controller
{
    /**
     * Create a new controller instance.
     * User must be logged in to access these pages
     *
     * @return void
     *
     * author: A. Delavau
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * Seach files in database
     *
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau, queries by Y. Merle
     */
    public function index()
    {

        $query = \Request::get('search');

        if ($query) {
            $files = File::where('name', 'LIKE', "%$query%")->orderBy('name')->paginate(10);
        } else {
            $files = File::orderBy('name', 'asc')->paginate(10);
        }

        return view('files.index')->with('files', $files);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * Store files in database and in a directory
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function store(Request $request)
    {
        // Check if a file is sent
        if ($request->hasFile('file')) {

            $filenameWithExt = $request->file('file')->getClientOriginalName();
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();

            // We create an array with the file extensions allowed
            $allowed = ['exe', 'EXE', 'msi', 'MSI'];

            // Create a path to store the file in the public directory
            $path = $request->file('file')->storeAs('public/files', $filenameWithExt);


            // Check if the file sent has the right extension, then we store it in the database
            if (in_array($extension, $allowed)) {

                $file = new File;
                $file->name = $filenameWithExt;
                $file->file_url = '../storage/files/' . $filenameWithExt;
                $file->save();

                return redirect('files')->with('success', 'Fichier ajouté');

            } else {
                return redirect('files')->with('error', 'Le fichier doit être au format .exe ou .msi');
            }

        } else {
            return redirect('files')->with('error', 'Aucun fichier envoyé');
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function show($id)
    {
//        $file = File::find($id);
//        return view('files.show')->with('files', $file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete all files from the database
     *
     * Delete all files from the storage directory
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * author: A. Delavau
     */

    public function deleteAll()
    {
        $file = File::all();
        $directory = new Filesystem();

        //Check if there are files to delete
        if (count($file) > 0) {
            File::truncate();
            $directory->cleanDirectory('public/files/');
            return redirect('/files')->with('success', 'Tous les fichiers ont été supprimés');
        } else {
            return redirect('/files')->with('error', 'Il n\'y a aucun fichier');

        }
    }


    /**
     * Remove the specified resource from storage and directory
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function destroy($id)
    {
        $file = File::find($id);

        if (File::exists()) {
            $file->delete();
            Storage::delete('public/files/' . $file->name);
            return redirect('/files')->with('success', 'Fichier supprimé');
        }
    }
}
