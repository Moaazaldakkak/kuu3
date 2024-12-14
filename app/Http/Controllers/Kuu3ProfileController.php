<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class Kuu3ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $profiles = Profile::paginate(20);
        return view('profiles.profiles', compact('profiles'));
    }

    public function create()
    {
        $profile = new Profile(); // Empty profile instance
        return view('profiles.form', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profiles.form', compact('profile'));
    }


    public function update(Request $request, Profile $profile)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'social_media_accounts' => 'nullable|array',
            'social_media_accounts.*.platform' => 'nullable|string',
            'social_media_accounts.*.link' => 'nullable|url',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($profile->image) {
                $oldImagePath = str_replace('/storage/', '', $profile->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('image');
            $filename = uniqid() . '.webp';

            // Process the image (resize and convert to WebP)
            $processedImage = Image::read($image)
                ->cover(480, 480, 'center') // Crop to 480x480
                ->toWebp(90); // Encode as JPG with 90% quality

            // Save the new image to storage
            $path = 'images/' . $filename;
            Storage::disk('public')->put($path, $processedImage);

            $validated['image'] = '/storage/' . $path;
        }

        // Update the profile with validated data
        $profile->update($validated);

        // Redirect back to the profiles page with a success message
        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'social_media_accounts' => 'nullable|array',
            'social_media_accounts.*.platform' => 'required_with:social_media_accounts|string',
            'social_media_accounts.*.link' => 'required_with:social_media_accounts|url',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Generate a unique file name
            $filename = uniqid() . '.webp';
    
            // Resize and crop the image to 480x480
            $croppedImage = Image::read($image)
                ->cover(480, 480, 'center') // Crop to 480x480
                ->toWebp(90); // Encode as JPG with 90% quality
    
            // Save the cropped image to the public storage
            $path = 'images/' . $filename;
            Storage::disk('public')->put($path, $croppedImage);
        
            $validated['image'] = '/storage/' . $path;
        }
    
        $validated['social_media_accounts'] = $request->input('social_media_accounts') 
            ? $request->input('social_media_accounts')
            : null;
    
        Profile::create($validated);
    
        return redirect()->route('profiles.index')->with('success', 'Profile created successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Profile $profile)
    {
        return view('profiles.show', compact('profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Profile $profile)
    {
        // Delete the profile's associated image if it exists
        if ($profile->image) {
            $imagePath = str_replace('/storage/', '', $profile->image);
            Storage::disk('public')->delete($imagePath);
        }
    
        // Delete the profile
        $profile->delete();
    
        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully!');
    }
    
}
