<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
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
     * Search users in database
     *
     * @return \Illuminate\Http\Response
     *
     * authors: A. Delavau, queries by Y. Merle
     */
    public function index()
    {

        $query = \Request::get('search');
        $choice = \Request::get('choice');
        $users = null;

        if ($query)
        {
            if($choice == 'name') {

                $users = User::where('lastname', 'LIKE', '%' . $query . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $query . '%')
                    ->join('classes_list', 'users.class_id', 'classes_list.id')
                    ->select('users.*', 'classes_list.name')
                    ->orderBy('lastname')
                    ->orderBy('firstname')
                    ->paginate(10);

            } elseif($choice == 'class') {

                $users = User::where('name', 'LIKE', '%' . $query . '%')
                        ->join('classes_list', 'users.class_id', 'classes_list.id')
                        ->select('users.*', 'classes_list.name')
                        ->orderBy('lastname')
                        ->orderBy('firstname')
                        ->paginate(10);
                }

        }
        else
        {
            $users = User::join('classes_list', 'users.class_id', 'classes_list.id')
                ->select('users.*', 'classes_list.name')
                ->orderBy('lastname')
                ->paginate(10);
        }

        return view('users.index')->with('users', $users);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'username' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $class_list = DB::table('classes_list')
            ->select('id')
            ->where('name', $request['class'])
            ->get();

        //Variables for checking if a user is already in database
        $lastname = User::where('lastname', $request['lastname'])->exists();
        $firstname = User::where('firstname', $request['firstname'])->exists();
        date_default_timezone_set('Europe/Paris');

        // Check if the passwords match and if user doesn't exists
        if($request['password'] == $request['confirm_password']) {
            if($lastname && $firstname) {
                return redirect('/dashboard')->with('error', 'Cet utilisateur existe déjà');
            } else {

                $user = new User;
                $user->lastname = $request['lastname'];
                $user->firstname = $request['firstname'];
                $user->username = $request['username'];
                $user->password = Hash::make($request['password']);
                $user->email = $request['username'] . '@exemple.com';
                $user->created_at = date('Y-m-d G:i:s');

                if($request['role']) {
                    $user->role = User::ADMIN_TYPE;
                    $user->save();
                } else {
                    $this->validate($request, [
                        'class' => 'required',
                    ]);
                    $user->class_id = $class_list[0]->id;
                    $user->role = User::DEFAULT_TYPE;
                    $user->save();
                }
                return redirect('/dashboard')->with('success', 'Utilisateur ajouté');
            }


        } else {
            return redirect('/dashboard')->with('error', 'Les mots de passe doivent être identiques');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
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
     *
     * author: A. Delavau
     */
    public function edit($id)
    {
        //Get users data from the database to fill the fields in the form
        //Get classes names from the database to fill the select input

        $data = [
            'user' => User::find($id),
            'list_lp' => DB::table('classes_list')->select('name')->where('etablissement', '=', 'LP')->get(),
            'list_lg' => DB::table('classes_list')->select('name')->where('etablissement', '=', 'LG')->get()];

        return view('users/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'username' => 'required',
        ]);

        //Set the right timezone for the update
        date_default_timezone_set('Europe/Paris');

        //Get the id of the class name in the 'classes_list' table, since we need to insert it in the 'users' table
        $class_list = DB::table('classes_list')
            ->select('id')
            ->where('name', $request['class'])
            ->get();

        //The password related fields are only required when the password is updated
        if($request['password']) {

            $this->validate($request, [
                'confirm_password' => 'required'
            ]);

            //Check if new passwords match
            if($request['password'] == $request['confirm_password']) {

                $post = User::find($id);
                $post->password = Hash::make($request['password']);
                $post->save();
                return redirect('/users')->with('success', 'Mot de passe modifié');
            } else {
                return redirect('/users/'.$id.'/edit')->with('error', 'Les mots de passe doivent être identiques');
            }


        }

        $post = User::find($id);
        $post->lastname = $request->input('lastname');
        $post->firstname = $request->input('firstname');
        $post->username = $request->input('username');
        $post->email = $post->username . '@exemple.com';
        $post->touch();
        $post->save();

        foreach ($class_list as $list) {

            $post->class_id = $list->id;
            $post->touch();
            $post->save();

        }

        // Change the user role, if needed
        if($request['role']) {
            $post = User::find($id);
            $post->role = User::ADMIN_TYPE;
            $post->save();
        }

        return redirect('/users')->with('success', 'Données utilisateur modifiées');
    }

    /**
     * Delete all non admin users from the database
     *
     * @return \Illuminate\Http\RedirectResponse
     * author: A. Delavau
     */

    public function deleteAll()
    {
        $user = User::all();
        if(count($user) > 0) {
            User::where('role', 'member')->delete();
            return redirect('/users')->with('success', 'Tous les utilisateurs ont été supprimés');
        } else {
            return redirect('/users')->with('error', 'Il n\'y a aucun utilisateur');

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * author: A. Delavau
     */
    public function destroy($id)
    {
        //Delete a user from its id
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'Utilisateurs supprimé');
    }


    /**
     * Add new users in the database from a CSV file
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * author: A. Delavau
     */

    public function csvUpload(Request $request)
    {
        //Check if a file is sent in the form
        if($request->hasFile('csv_file')) {

            $filenameWithExt = $request->file('csv_file')->getClientOriginalName();
            $filepath = $request->file('csv_file')->getRealPath();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('csv_file')->getClientOriginalExtension();
            $allowed = ['csv', 'CSV'];


            //Check if the file has the right extension before opening and reading it
            if(in_array($extension, $allowed)) {
                date_default_timezone_set('Europe/Paris');

                $handle = fopen($filepath, "r");
                $header = true;

                //Read the csv file, skip the header and add each value in database
                while ($csvLine = fgetcsv($handle, 1000, ";")) {

                    if ($header) {
                        $header = false;
                    } else {
                        $class_list = DB::table('classes_list')
                            ->select('id')
                            ->where('name', $csvLine[0])
                            ->get();

                        foreach ($class_list as $list) {
                            User::create([
                            'lastname' => $csvLine[1],
                            'firstname' => $csvLine[2],
                            'username' => $csvLine[5],
                            'password' => Hash::make($csvLine[3]),
                            'email' => $csvLine[5] . '@exemple.com',
                            'class_id' => $list->id,
                            'created_at' => date('Y-m-d G:i:s')
                            ]);
                        }
                    }
                }
                fclose($handle);

                return redirect('users')->with('success', 'Utilisateurs ajoutés');

            } else {
                return redirect('users')->with('error', 'Votre fichier doit être au format .csv');
            }

        } else {
            return redirect('users')->with('error', 'Aucun fichier envoyé');
        }

    }

}
