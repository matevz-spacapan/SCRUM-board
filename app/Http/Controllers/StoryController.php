<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stories = DB::select('SELECT * from stories');
        return view('story.index', ['stories' => $stories]);
    }

    public function create()
    {
        $this->authorize('create', Story::class);
        return view('story.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tests' => ['required', 'string'],
            'priority' => 'required',
            'business_value' => ['required', 'numeric', 'min:0']
        ]);

        Story::create($data);

        return redirect()->route('story.index');
    }
}
