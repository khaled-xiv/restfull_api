<?php

namespace App\Http\Controllers\User;

use App\Enums\Role;
use App\Enums\VerficationStatus;
use App\Http\Controllers\ApiController;
use App\Models\User;

class UserController extends ApiController
{
    public function index()
    {
        $users=User::all();
        return $this->showAll($users);
    }

    public function store()
    {
        $request=request();
        $rules=[
          'name'=>'required',
          'email'=>'required|email|unique:users',
          'password'=>'required|min:6',
        ];

        $this->validate($request,$rules);
        return $data=$request->all();
        $data['verified']=VerficationStatus::UNVERIFIED;
        $data['verification_token']=User::generateVerificationCode();
        $data['admin']=Role::REGULAR;
        $user=User::create($data);

        return $this->showOne($user,201);

    }

    public function show(User $user)
    {
        return $this->showOne($user);
    }

    public function update(User $user)
    {
        $request=request();
        $rules=[
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6',
            'admin'=>'in:'.Role::REGULAR.','.Role::ADMIN,
        ];

        $this->validate($request,$rules);

//        $user->fill($request->only([
//            'name','email','password'
//        ]));

        if($request->has('name'))
            $user->name=$request->name;
//
        if($request->has('email') && $user->email!=$request->email){
            $user->verified=VerficationStatus::UNVERIFIED;
            $user->verification_token=User::generateVerificationCode();
            $user->email=$request->email;
        }
//
        if($request->has('password'))
            $user->password=$request->password;

        if($request->has('admin')){
            if(!$user->verified)
                return $this->errorResponse('Only verified users can modify the admin field',409);

            $user->admin=$request->admin;
        }

//        if($user->isClean()){
//            return $this->errorResponse('You need to specify a different value to modify',422);
//        }

        if(!$user->isDirty()){
            return $this->errorResponse('you need to specify a different value to modify',422);
        }

        $user->save();

        return $this->showOne($user,201);

    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token)
    {
        $user=User::where('verification_token',$token)
            ->firstOrFail();
        $user->verified=VerficationStatus::VERIFIED;
        $user->verification_token=null;

        $user->save();

        return $this->showMessage('The account has been verified successfully');

    }

}
