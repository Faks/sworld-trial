<?php

namespace App\Http\Controllers\Api;

use App\Documents;
use App\Http\Requests\AuthStore;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Storage;
use function config;
use function is_numeric;
use function response;

class AuthController
{
    /**
     * @param mixed $getToken
     * @return JsonResponse|null
     */
    public function index($getToken) : ?JsonResponse
    {
        $getUserId = $this->tokenCheck($getToken)->getData(true)['data'];
        
        $getUserDocuments = Documents::query()
            ->where('created_by', $getUserId)
            ->get();
        
        if ($getUserDocuments->count() >= 1) {
            return response()->json($getUserDocuments);
        }
        
        return response()->json(['invalid data or token'], 403);
    }
    
    /**
     * @param mixed     $getToken
     * @param AuthStore $authStore
     * @return JsonResponse|null
     */
    public function store($getToken, AuthStore $authStore) : ?JsonResponse
    {
        $getUserId = $this->tokenCheck($getToken)->getData(true)['data'];
        
        if (is_numeric($getUserId)) {
            $store_document                 = new Documents();
            $store_document->file_name      = $authStore->file('pdf')->getClientOriginalName();
            $store_document->file_extension = $authStore->file('pdf')->getClientOriginalExtension();
            $store_document->file_mime_type = $authStore->file('pdf')->getClientMimeType();
            $store_document->file_size      = $authStore->file('pdf')->getSize();
            $store_document->file_path      = config()->get('filesystems.disks.public.access');
            $store_document->created_by     = $getUserId;
            $store_document->save();
            
            $path = Storage::putFileAs(
                config()->get('filesystems.disks.public.store'),
                $authStore->file('pdf'),
                $authStore->file('pdf')->getClientOriginalName()
            );
            
            return response()->json([
                'file_name'      => $authStore->file('pdf')->getClientOriginalName(),
                'file_extension' => $authStore->file('pdf')->getClientOriginalExtension(),
                'file_mime_type' => $authStore->file('pdf')->getClientMimeType(),
                'store'          => $path,
                'model'          => $store_document,
                'success'        => true,
            ]);
        }
        
        return response()->json(['invalid data or token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @return JsonResponse
     */
    public function tokenCheck($getToken) : JsonResponse
    {
        try {
            $getUser = User::query()->where('api_token', $getToken)->firstOrFail();
            
            return response()->json(['data' => $getUser->id]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['data' => false]);
        }
    }
}
