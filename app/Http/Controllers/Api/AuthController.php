<?php

namespace App\Http\Controllers\Api;

use App\Documents;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;
use function config;
use function response;

class AuthController
{
    /**
     * @param mixed $getToken
     * @return JsonResponse|null
     */
    public function index($getToken) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json(Documents::all());
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @return JsonResponse
     */
    public function tokenCheck($getToken) : JsonResponse
    {
        try {
            User::query()->where('api_token', $getToken)->firstOrFail();
            
            return response()->json(['data' => true]);
        } catch (Exception $exception) {
            return response()->json(['data' => $exception->getMessage()]);
        }
    }
    
    /**
     * @param mixed   $getToken
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store($getToken, Request $request) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            $store_document                 = new Documents();
            $store_document->file_name      = $request->file('pdf')->getClientOriginalName();
            $store_document->file_extension = $request->file('pdf')->getClientOriginalExtension();
            $store_document->file_mime_type = $request->file('pdf')->getClientMimeType();
            $store_document->file_size      = $request->file('pdf')->getSize();
            $store_document->file_path      = config()->get('filesystems.disks.public.access');
            $store_document->save();
            
            $path = Storage::putFileAs(
                config()->get('filesystems.disks.public.store'),
                $request->file('pdf'),
                $request->file('pdf')->getClientOriginalName()
            );
            
            return response()->json([
                'file_name'      => $request->file('pdf')->getClientOriginalName(),
                'file_extension' => $request->file('pdf')->getClientOriginalExtension(),
                'file_mime_type' => $request->file('pdf')->getClientMimeType(),
                'store'          => $path,
                'model'          => $store_document,
            ]);
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed          $getToken
     * @param \App\Documents $documents
     * @param Request        $request
     * @return JsonResponse|null
     * @throws Exception
     */
    public function destroy($getToken, Documents $documents, Request $request) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            if (File::exists($documents->file_path . $documents->file_name)) {
                File::delete($documents->file_path . $documents->file_name);
            }
            $documents->delete();
            
            return response()->json(['data' => true]);
        }
        
        return response()->json(['invalid token'], 403);
    }
}
