<?php

namespace App\Http\Repository\Users;
use App\Contracts\Users\UserRepositoryInterface;
use App\Http\Requests\users\UserRequest;
use App\Models\Group;
// declare Entities
use App\Models\User;
use App\Models\user_group;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
class UserRepository implements UserRepositoryInterface
{
public function index(){
 
 
     if(isset(request()->search)  AND $users  =  User::with('groups')->where('user_name',  request()->search )->paginate(10) )
        {
        return $users  ;
            // return $users->where('user_name',  request()->search )->paginate(10);
                
            // return $users->paginate(10); 
               
                     
        }
         $users  =  User::with('groups')->paginate(10);
   return $users;
   
}

    public function get_all_users()
    {
        return User::all();
    }

    public function create_user(){}
	public function store_user($request){
       
        $user=new User();
        $user->user_name=$request->user_name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->role=$request->role;
        if(empty($request->phone))
        {
         $user->phone=''; 
        }else{
         $user->phone=$request->phone;
        }
        if(empty($request->active))
        {
         $user->active='0'; 
        }else{
         $user->active=$request->active;
        }
       
        $user->ip_address=$request->ip();
        $user->save();
        foreach( $request->groups as $gr){
            $gp=new user_group();
			$gp->group_id=$gr;
			$gp->user_id=$user->id;
			$gp->save();

        }
        
        \App\Models\AdministrationLog::create([
            'user_id' => \Auth::id(),
            'category' => 'User',
            'action' => 'Create',
            'details' => "Created user {$user->user_name} (ID: {$user->id})"
        ]);
 
    }

    public function update(User $user,Request $request){
        // Capture old values for comparison if desired, or just log the action
        $oldData = $user->getOriginal();

        $user->user_name=$request->user_name;
        $user->email=$request->email;
        if(!empty($request->password))
        {
            $user->password=Hash::make($request->password);
        }
     
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
         $user->role=$request->role;
        if(empty($request->phone))
        {
         $user->phone=''; 
        }else{
         $user->phone=$request->phone;
        }
        if(empty($request->active))
        {
         $user->active='0'; 
        }else{
         $user->active=$request->active;
        }
       
        $user->ip_address=$request->ip();
        $user->save();
        $user->groups()->sync($request->groups);
        
        \App\Models\AdministrationLog::create([
            'user_id' => \Auth::id(),
            'category' => 'User',
            'action' => 'Update',
            'details' => "Updated user {$user->user_name} (ID: {$user->id})"
        ]);

    }
	
	public function getUserGroupsMember()
	{
		return DB::table('user_groups')
		 ->select('users.id','users.user_name')
		 ->join('users', 'user_groups.user_id', '=', 'users.id')
		 ->join('groups', 'user_groups.group_id', '=', 'groups.id')
		 ->whereIn('user_groups.group_id', [1,10])
		 ->get();
	}

}



