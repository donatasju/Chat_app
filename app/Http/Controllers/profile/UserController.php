<?php

namespace App\Http\Controllers\profile;

use App\User;
use App\Traits\Navigation\AddsNavigation;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AddsNavigation;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->addNavigation();
        $users = Auth::User();

        return view('users', [
            'title' => __('users'),
            'users' => $users,
//            'editable' => $editable
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('userdesc', [
            'title' => __('users'),
            'users' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->addNavigation();
        $form = [
            'action' => ['Profile\UserController@update', $user->id],
            'method' => 'PUT',
            'fields' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'input',
                    'value' => $user->name,
                    'name' => 'name',
                    'attr' => [
                        'placeholder' => 'Role name',
                        'class' => 'name-field'
                    ]
                ],
                'email' => [
                    'label' => 'email',
                    'type' => 'input',
                    'value' => $user->email,
                    'name' => 'email',
                    'attr' => [
                        'placeholder' => 'Email',
                    ]
                ],
                'img' => [
                    'label' => 'Image',
                    'type' => 'input',
                    'value' => $user->profile_image,
                    'name' => 'Image',
                    'attr' => [
                        'placeholder' => 'Image',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'type' => 'password',
                    'value' => '',
                    'name' => 'password',
                    'attr' => [
                        'placeholder' => 'Password',
                    ]
                ],
                [
                    'type' => 'button',
                    'title' => 'Edit',
                    'attr' => ''
                ]
            ],
        ];

        return view('edit', [
            'title' => __('edit'),
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->profile_image = $request->input('profile_image');
        $user->password = bcrypt($request->input('password'));

        $user->save();

        return redirect('/users')->with(['success' => 'User has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
