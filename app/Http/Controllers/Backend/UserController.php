<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function UserView()
    {

        // $allData = User::all();
        $data['allData'] = User::all();
        return view('backend.user.view_user', $data);

    }




    public function UserAdd()
    {
        return view('backend.user.add_user');

    }


    public function UserStore(Request $request)
    {


        $validatedData = $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',

        ]);

        $data = new User();

        $data->suertype = $request->suertype;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $notification = array(
            'message' => 'Utilisateur ajouté avec succès',
            'alert-type' => 'success'
        );

        $data->save();
        return redirect()->route('user.view')->with($notification);


    }


    public function UserEdit($id)
    {
        $editData = User::find($id);
        return view('backend.user.edit_user', compact('editData'));

    }
    public function UserUpdate(Request $request, $id)
    {
        $data = User::find($id);

        $data->suertype = $request->suertype;
        $data->name = $request->name;
        $data->email = $request->email;

        $notification = array(
            'message' => 'Utilisateur modifié avec succès',
            'alert-type' => 'info'
        );

        $data->save();
        return redirect()->route('user.view')->with($notification);

    }



    public function UserDelete($id){

        $user = User::find($id);
        $user->delete();

        $notification = array(
            'message' => 'Utilisateur supprimé avec succès',
            'alert-type' => 'info'
        );
        return redirect()->route('user.view')->with($notification);


    }
}