<?php
namespace App\Http\Controllers\Postman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostmanCollectionController extends Controller
{

    public function index()
    {
        $directory = 'postman';
        $files     = Storage::files($directory);

        $collections = [];

        foreach ($files as $file) {
            if (str_ends_with($file, '.postman_collection.json')) {
                $json = Storage::get($file);
                $data = json_decode($json, true);

                if (isset($data['info']['name'])) {
                    $collections[] = [
                        'name' => $data['info']['name'],
                        'path' => $file,
                    ];
                }
            }
        }



        // Return to view or response
        return view('postman.collection.index', compact('collections'));
    }

    public function show(Request $request)
    {
        $collection = json_decode(Storage::get('postman/collection.json'), true);

        $environment = json_decode(Storage::get('postman/environment.json'), true);

        $base_url = $environment['values']['base_url']['value'] ?? 'http://127.0.0.1:8000';
        $token    = $environment['values']['token']['value'] ?? '';

        $groups = [];
        try {
            if (! isset($collection['item']) || ! is_array($collection['item'])) {
                throw new \Exception('Invalid collection format');
            }
        } catch (\Exception $e) {
            return redirect()->route('postman.collection.upload')->withErrors(['postman_collection' => 'Invalid Postman collection format.']);
        }

        foreach ($collection['item'] as $item) {
            if (isset($item['item'])) {
                $groups[] = [
                    'name'  => $item['name'] ?? 'Unnamed Folder',
                    'items' => $item['item'],
                ];
            } else {
                $groups[] = [
                    'name'  => 'Ungrouped',
                    'items' => [$item],
                ];
            }
        }

        $selectedIndex = $request->query('folder', 0);
        $selectedGroup = $groups[$selectedIndex] ?? null;

        return view('postman.collection.show', compact('groups', 'selectedIndex', 'selectedGroup', 'base_url', 'token'));
    }

    public function uploadForm()
    {
        return view('postman.collection.upload');
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'postman_collection' => 'required|file|mimes:json|max:2048',
        ], [], [
            'postman_collection' => 'Postman Collection File',
        ]);

        $file = $request->file('postman_collection');

        // Use the original file name
        $originalName = $file->getClientOriginalName();
        $path         = $file->storeAs('postman', $originalName); // storage/app/postman/{original_filename}.json

        // Optional: parse and validate content
        $json       = Storage::get($path);
        $collection = json_decode($json, true);

        if (! $collection || ! isset($collection['info'])) {
            return back()->withErrors(['postman_collection' => 'Invalid Postman collection JSON.']);
        }

        return redirect()->route('postman.collection.index')->with([
            'success' => 'Postman collection uploaded successfully.',
        ]);
    }

    public function storeEnvironment(Request $request)
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

        return redirect()->route('postman.collection.index')->with([
            'success' => 'Postman environment uploaded successfully.',
        ]);
    }
}
