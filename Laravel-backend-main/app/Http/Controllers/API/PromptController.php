<?php

namespace App\Http\Controllers\Api;

use App\Models\Prompt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PromptRequest;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        {
            $prompt = Prompt::select('users.name', 'prompts.prompt', 'prompts.sender','prompts.created_at', 'prompts.prompt_id', 'prompts.user_id')
                                    ->join('users', 'prompts.user_id', '=', 'users.id');
    
            if ($request->keyword) {
                $prompt->where(function ($query) use ($request) {
                    $query->where('users.name', 'ilike', '%' . $request->keyword . '%')
                        ->orWhere('prompts.prompt', 'ilike', '%' . $request->keyword . '%');
                });
            }
    
            return $prompt->get();
        }

        return Prompt::all();
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromptRequest $request)
    {
        $validated = $request->validated();

        $prompt = Prompt::create($validated);

        return $prompt;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Prompt::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PromptRequest $request, string $id)
    {
        $validated = $request->validated();

        $prompt = Prompt::findOrFail($id);

        $prompt->update($validated);

        return $prompt;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prompt = Prompt::findOrFail($id);

        $prompt->delete();

        return $prompt;
    }
}
