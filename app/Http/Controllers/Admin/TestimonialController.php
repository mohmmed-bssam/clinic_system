<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::with('media')->orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'status' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $image = $data['image'];
        unset($data['image']);

        $testimonial = Testimonial::create($data);

        Media::create([
            'path' => $image->store('uploads/testimonials', 'custom'),
            'type' => $image->getMimeType(),
            'mediable_id' => $testimonial->id,
            'mediable_type' => Testimonial::class,
        ]);

        flash()->success('Testimonial created successfully');

        return Redirect::route('admin.testimonials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial): View
    {
        $testimonial->load('media');

        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'status' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        unset($data['image']);

        $testimonial->update($data);

        if ($request->hasFile('image')) {
            $media = $testimonial->media()->first();

            if ($media !== null) {
                File::delete(public_path($media->path));
            }

            $path = $request->file('image')->store('uploads/testimonials', 'custom');

            if ($media !== null) {
                $media->update([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                ]);
            } else {
                Media::create([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                    'mediable_id' => $testimonial->id,
                    'mediable_type' => Testimonial::class,
                ]);
            }
        }

        flash()->success('Testimonial updated successfully');

        return Redirect::route('admin.testimonials.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $media = $testimonial->media()->first();

        if ($media !== null) {
            File::delete(public_path($media->path));
            $media->delete();
        }

        $testimonial->delete();
        flash()->success('Testimonial deleted successfully');

        return Redirect::route('admin.testimonials.index');
    }
}
