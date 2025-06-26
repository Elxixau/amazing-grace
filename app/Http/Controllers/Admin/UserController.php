<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    // User index Page
    public function index(Request $request)
    {
         $totalUsers = User::count();

    $query = User::query();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('divisi')) {
        $query->where('divisi', $request->divisi);
    }

    $users = $query->latest()->paginate(10);

    return view('admin.users.index', compact('users', 'totalUsers'));
    }

    // User Edit Page
    public function edit($id){
   

        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Create the User
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'divisi' => 'required|in:pubdok,acara,inti,perlengkapan,humas',
            'password' => 'required',
        ]);

        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'divisi' => $request->divisi,
            'password' => bcrypt($request->password), // Hash the password
        ]);



         return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'divisi' => 'required|in:inti,acara,pubdok,perlengkapan,humas',
        'password' => 'nullable',
        'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->divisi = $request->divisi;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    if ($request->hasFile('profile_img')) {
        $imagePath = $request->file('profile_img')->store('profile_images', 'public');
        $user->profile_img = $imagePath;
    }

    $user->save();

    return redirect()->route('admin.user.edit', $user->id)->with('success', 'Perubahan data berhasil.');
}


    public function delete($id)
    {
        
        $users = User::find($id);

        $users->delete();

        return redirect()->route('admin.user.index')->with('success', 'Anggota berhasil dihapus.');
    }

}
