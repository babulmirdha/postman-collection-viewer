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
                        'path' => basename($file),
                    ];
                }
            }
        }

        // Return to view or response
        return view('postman.collection.index', compact('collections'));
    }

    public function show($id, Request $request)
    {

        $collection = json_decode(Storage::get("postman/$id"), true);

        $environment = json_decode(Storage::get('postman/environment.json'), true);

        $base_url = $environment['values']['base_url']['value'] ?? 'http://127.0.0.1:8000';
        $token    = $environment['values']['token']['value'] ?? '';

        $groups = [];
        try {
            if (! isset($collection['item']) || ! is_array($collection['item'])) {
                throw new \Exception('Invalid collection format');
            }
        } catch (\Exception $e) {
            return redirect()->route('postman.collections.upload')->withErrors(['postman_collection' => 'Invalid Postman collection format.']);
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

        return view('postman.collection.show', compact('id', 'groups', 'selectedIndex', 'selectedGroup', 'base_url', 'token'));
    }

    public function uploadForm()
    {
        return view('postman.collection.upload');
    }

    public function storeFile(Request $request)
    {

        $request->validate([
            'postman_collection' => 'required|file|max:2048',
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

        return redirect()->route('postman.collections.index')->with([
            'success' => 'Postman collection uploaded successfully.',
        ]);
    }

    public function download($id)
    {
        $filePath = "postman/{$id}";

        if (! Storage::exists($filePath)) {
            abort(404);
        }

        return Storage::download($filePath);
    }

    public function destroy($id)
    {
        $filePath = "postman/{$id}";

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return back()->with('success', 'Postman collection deleted successfully.');
        }

        return back()->withErrors(['error' => 'File not found.']);
    }

}
