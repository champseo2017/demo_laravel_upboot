<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Model\domain;

class AdduserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adduser = User::orderBy('created_at','DESC')->get();
        return view('admin')->with(compact('adduser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domain = domain::all();

        return view('admin.adduser.add',compact('domain'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $adduser = new User;
        $adduser->name = $request->name;
        $adduser->email = $request->email;
        $adduser->password = Hash::make(Input::get('password'));
        $adduser->save();
        $adduser->domains()->sync($request->domains);
        return redirect(route('adduser.index'))->with('success','You have Add successfully.');


        
        // $imgName = $request->file('image')->getClientOriginalName();
        // $request->file('image')->move(public_path('user/imgpost'), $imgName);
        // $post->image = '/public/user/imgpost/'.$imgName;
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
        $adduser = User::where('id',$id)->first();
        return view('admin.adduser.edit',compact('adduser'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->delete();
        return redirect()->back();
    }
}
