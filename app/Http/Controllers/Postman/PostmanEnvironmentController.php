<?php
namespace App\Http\Controllers\Postman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostmanEnvironmentController extends Controller
{

    public function show(Request $request)
    {

        $json        = Storage::get('postman/environment.json');
        $environment = json_decode($json, true);

        return view('postman.environment.show', compact('environment'));
    }

    public function uploadForm()
    {
        return view('postman.environment.upload');
    }

    public function storeFile(Request $request)
    {

        $request->validate([
            'postman_environment' => 'required|file|mimes:json|max:1024',
        ], [], [
            'postman_environment' => 'Postman Environment File',
        ]);

        $file = $request->file('postman_environment');

                                                               // Save permanently
        $path = $file->storeAs('postman', 'environment.json'); // storage/app/postman/environment.json

        // Optional: validate structure
        $json        = Storage::get($path);
        $environment = json_decode($json, true);

        if (! $environment || ! isset($environment['values'])) {
            return back()->withErrors(['postman_environment' => 'Invalid Postman environment JSON.']);
        }

        return redirect()->route('postman.environment.index')->with([
            'success' => 'Postman environment uploaded successfully.',
        ]);
    }

    public function editVariables()
    {
        $json        = Storage::get('postman/environment.json');
        $environment = json_decode($json, true);

        return view('postman.environment.edit', compact('environment'));
    }

    public function updateVariables(Request $request)
    {
        $data = $request->input('env');

        $json        = Storage::get('postman/environment.json');
        $environment = json_decode($json, true);

        // Update environment values
        foreach ($environment['values'] as &$envVar) {
            foreach ($data as $input) {
                if ($envVar['key'] === $input['key']) {
                    $envVar['value'] = $input['value'];
                }
            }
        }

        Storage::put('postman/environment.json', json_encode($environment, JSON_PRETTY_PRINT));

        return redirect()->route('postman.environment.index')->with('success', 'Environment updated successfully.');
    }

}
