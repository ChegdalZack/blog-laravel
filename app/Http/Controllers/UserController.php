<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
      public function getUsers(){
        $users=[
            ["id"=>1,'name'=>'amine','email'=>"amine@gmail.com" ,'isAdmin'=>true],
            ["id"=>2,'name'=>'mourid','email'=>"mourid@gmail.com" ,'isAdmin'=>false],
            ["id"=>3,'name'=>'john','email'=>"john@gmail.com" ,'isAdmin'=>true],
        ];
         
       return view('Users',['users'=>$users]);
      }


      
      public function details($id)
      {
        $data=[];

        $users=[
            ["id"=>1,'name'=>'amine','email'=>"amine@gmail.com" ,'isAdmin'=>true],
            ["id"=>2,'name'=>'mourid','email'=>"mourid@gmail.com" ,'isAdmin'=>false],
            ["id"=>3,'name'=>'john','email'=>"john@gmail.com" ,'isAdmin'=>true],
        ];
         
        foreach ($users as $user) {
            if($user['id']==$id)
            {
                $data=$user;
            }
        }
    
          return view('details',['userInfo'=>$data]);
      }
}
