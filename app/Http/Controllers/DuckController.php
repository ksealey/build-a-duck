<?php

namespace App\Http\Controllers;

use App\Models\Duck;
use App\Strategies\GenerateImage\GenerateJPEG;
use App\Strategies\GenerateImage\GeneratePNG;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DuckController extends Controller
{
    /**
     * Search for a duck
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Http\Response 
     */
    public function index(Request $request)
    {
        return Inertia::render('Ducks/Index', [
            'ducks' => $request->user()->ducks()->get(),
        ]);
    }

    /**
     * Display form to create a duck
     * 
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Ducks/Create');
    }

    /**
     * Store a duck
     * 
     * @param Illuminate\Http\Request $request 
     * 
     * @return Illuminate\Http\Redirect
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:20',
            'color' => 'required|hex_color',
            'hair' => 'nullable|in:hair_1,hair_2,hair_3',
            'accessory' => 'nullable|in:acc_1,acc_2,acc_3',
            'shoes' => 'nullable|in:shoes_1,shoes_2,shoes_3',
        ]);

        //  Generate, store and attach an SVG image for previewing
        $duck = new Duck($data);
        $duck->image_path = 'ducks/' . Str::uuid() . '.png';
        Storage::disk('public')->put($duck->image_path, $duck->generateImage(new GeneratePNG()));

        $duck = $request->user()
                        ->ducks()
                        ->attach($duck);

        return to_route('ducks.view', [
            'duckId' => $duck->_id,
        ]);
    }

    /**
     * View a duck
     * 
     * @param Illuminate\Http\Request $request 
     * @param string $duckId
     * 
     * @return \Inertia\Response
     */
    public function view(Request $request, string $duckId)
    {
        $duck = $request->user()->ducks()->find($duckId);
        if(!$duck){
            abort(404);
        }

        return Inertia::render('Ducks/View', [
            'duck' => $duck,
        ]);
    }

    /**
     * Download a duck image
     * 
     * @param Illuminate\Http\Request $request 
     * @param string $duckId
     * 
     * @return \Inertia\Response
     */
    public function download(Request $request, string $duckId)
    {
        $duck = $request->user()->ducks()->find($duckId);
        if(!$duck){
            abort(404);
        }

        $format = $request->input('format') === 'jpeg' ? 'jpeg' : 'png';
        if($format === 'jpeg'){
            $imageData = $duck->generateImage(new GenerateJPEG());
        }else{
            $imageData = $duck->generateImage(new GeneratePNG());
        }

        return response()->stream(function() use($imageData) {
            echo $imageData;
        }, 200, [
            'Content-Type' => 'image/' . $format,
            'Content-Disposition' => 'attachment; filename="duck.' . $format .'"',
        ]);
    }
}
