<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Tag;
use App\Models\GuestStar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('guestStars', 'tags')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $tags = Tag::all();
        $post = null; // untuk keperluan form create
    return view('admin.posts.form', compact('tags', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'nullable|unique:posts,slug',
        'subtitle' => 'nullable|string|max:255',
        'excerpt' => 'nullable|string|max:500',
        'content' => 'nullable|string',
        'banner_image' => 'nullable|image|max:3072',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'location_name' => 'nullable|string|max:255',
        'location_details' => 'nullable|string',
        'map_embed_url' => 'nullable|string',
        'weekday_service_hours' => 'nullable|string|max:100',
        'weekend_service_hours' => 'nullable|string|max:100',
        'admin_name' => 'nullable|string|max:255',
        'admin_phone' => 'nullable|string|max:20',
        'admin_email' => 'nullable|email|max:255',
        'admin_whatsapp' => 'nullable|string|max:20',
        'admin_photo' => 'nullable|image|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:50',
        'status' => 'nullable|in:draft,published',
        'show' => 'nullable|boolean',
        'published_at' => 'nullable|date',
    ]);

    // Buat slug otomatis jika kosong
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
    }

    // Upload banner
    if ($request->hasFile('banner_image')) {
        $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
    }

    // Upload foto admin
    if ($request->hasFile('admin_photo')) {
        $validated['admin_photo'] = $request->file('admin_photo')->store('admin_photos', 'public');
    }

    // Konversi checkbox ke boolean
    $validated['show'] = $request->has('show');

    // Simpan post
    $post = Post::create($validated);

    // Simpan tags
    if ($request->filled('tags')) {
        $tagIds = collect($request->tags)->map(function ($tagName) {
            return \App\Models\Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            )->id;
        });
        $post->tags()->sync($tagIds);
    }

    // Simpan Guest Stars
    if ($request->has('guest_stars')) {
        foreach ($request->guest_stars as $starData) {
            if (!empty($starData['name'])) {
                $photoPath = null;

                if (isset($starData['photo']) && $starData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $photoPath = $starData['photo']->store('guest_photos', 'public');
                }

                $post->guestStars()->create([
                    'name' => $starData['name'],
                    'role' => $starData['role'] ?? '',
                    'photo' => $photoPath,
                ]);
            }
        }
    }

    return redirect()->route('admin.post.index')->with('success', 'Post berhasil dibuat');
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
    public function edit($slug)
    {
        $post = Post::with('tags', 'guestStars')->where('slug', $slug)->firstOrFail();;
        $tags = Tag::all();
        return view('admin.posts.form', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'nullable|unique:posts,slug,' . $post->id,
        'subtitle' => 'nullable|string|max:255',
        'excerpt' => 'nullable|string|max:500',
        'content' => 'nullable|string',
        'price' => 'nullable|string',
        'banner_image' => 'nullable|image|max:3072',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'location_name' => 'nullable|string|max:255',
        'location_details' => 'nullable|string',
        'map_embed_url' => 'nullable|string',
        'weekday_service_hours' => 'nullable|string|max:100',
        'weekend_service_hours' => 'nullable|string|max:100',
        'admin_name' => 'nullable|string|max:255',
        'admin_phone' => 'nullable|string|max:20',
        'admin_email' => 'nullable|email|max:255',
        'admin_whatsapp' => 'nullable|string|max:20',
        'admin_photo' => 'nullable|image|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:50',
        'status' => 'nullable|in:draft,published',
        'show' => 'nullable|boolean',
        'published_at' => 'nullable|date',
    ]);

    // Slug otomatis jika kosong
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
    }

    // Hapus gambar banner jika dicentang
if ($request->has('remove_banner_image') && $post->banner_image) {
    Storage::disk('public')->delete($post->banner_image);
    $validated['banner_image'] = null;
}

// Hapus foto admin jika dicentang
if ($request->has('remove_admin_photo') && $post->admin_photo) {
    Storage::disk('public')->delete($post->admin_photo);
    $validated['admin_photo'] = null;
}


    // Banner Image
    if ($request->hasFile('banner_image')) {
        if ($post->banner_image) {
            Storage::disk('public')->delete($post->banner_image);
        }
        $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
    }

    // Admin Photo
    if ($request->hasFile('admin_photo')) {
        if ($post->admin_photo) {
            Storage::disk('public')->delete($post->admin_photo);
        }
        $validated['admin_photo'] = $request->file('admin_photo')->store('admin_photos', 'public');
    }

    // Checkbox "show" ke boolean
    $validated['show'] = $request->has('show');

    // Update post
    $post->update($validated);

    // Tag mapping
if ($request->filled('tags')) {
    $tagIds = collect($request->tags)->map(function ($tagName) {
        // Normalisasi nama tag (misalnya hilangkan spasi ekstra dan lowercase)
        $normalizedName = trim($tagName);
        $slug = Str::slug($normalizedName);

        // Cari berdasarkan slug agar tidak duplikat
        $tag = Tag::firstOrCreate(
            ['slug' => $slug],
            ['name' => $normalizedName]
        );

        return $tag->id;
    });

    // Sinkronkan tag ke post
    $post->tags()->sync($tagIds);
} else {
    // Hapus semua tag jika tidak ada yang dikirim
    $post->tags()->sync([]);
}

    // Reset Guest Stars
    $post->guestStars()->delete();

    if ($request->has('guest_stars')) {
        foreach ($request->guest_stars as $starData) {
            if (!empty($starData['name'])) {
                $photoPath = null;
                if (isset($starData['photo']) && $starData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $photoPath = $starData['photo']->store('guest_photos', 'public');
                }

                $post->guestStars()->create([
                    'name' => $starData['name'],
                    'role' => $starData['role'] ?? '',
                    'photo' => $photoPath,
                ]);
            }
        }
    }

    return redirect()->route('admin.post.index')->with('success', 'Post berhasil diperbarui');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if ($post->banner_image) {
            Storage::disk('public')->delete($post->banner_image);
        }

        if ($post->admin_photo) {
            Storage::disk('public')->delete($post->admin_photo);
        }

        $post->guestStars()->delete();
        $post->tags()->detach();
        $post->delete();

        return back()->with('success', 'Eventh berhasil dihapus');
    }

    public function toggleShow($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->show = !$post->show;
        $post->save();

        return back()->with('success', 'Status tampil di halaman home diperbarui, berhasil menggunakan '. $post->title .' sebagai tampilan halaman' );
    }

}
