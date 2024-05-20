<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('parent_id', auth()->id())->get();
        return view('users/index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users/add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validating image
            'parent_id'=>['nullable', 'integer']
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $profileImage = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $profileImage);
        }
        $user =new User;
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password= Hash::make($request->input('password'));
        $user->image=$profileImage;
        $user->parent_id=auth()->id();
         $user->save();
         $notification = array(
            'message' => 'added user succesfully',
            'alert-type' => 'success'
        );
        
        return redirect()->route('users.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user=User::findOrFail($id);
        return view('users/edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'], // Password is optional
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Image is optional
        ]);
    
        if ($request->hasFile('image')) {
            // Upload and save the new profile image
            $image = $request->file('image');
            $profileImage = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $profileImage);
    
            // Delete the old profile image (optional)
            if ($user->image) {
                $oldImagePath = public_path('images/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $user->image = $profileImage;
        }
    
        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }    
        $user->save();
    
        $notification = [
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('users.index')->with($notification);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $notification = array(
           'message' => 'deleted user succesfully',
            'alert-type' =>'success'
        );
        return back()->with($notification);
    }
}
