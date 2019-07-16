<?php

namespace App\Http\Controllers\Api;

use App\Documents;
use App\User;
use Exception;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param mixed   $getToken
     * @param Request $request
     * @return JsonResponse|null
     */
    public function store($getToken, Request $request) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json($request);
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @param int   $id
     * @return JsonResponse|null
     */
    public function show($getToken, $id) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json(Documents::query()->find($id));
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed   $getToken
     * @param int     $id
     * @param Request $request
     * @return JsonResponse|null
     */
    public function update($getToken, $id, Request $request) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            $document = Documents::query()->find($id);
            $document->update(['file_name' => $request->get('file_name')]);
            
            return response()->json(['data' => true]);
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed   $getToken
     * @param int     $id
     * @param Request $request
     * @return JsonResponse|null
     * @throws Exception
     */
    public function destroy($getToken, $id, Request $request) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            $document = Documents::query()->find($id);
            if (File::exists($request->get('file_name'))) {
                File::delete($request->get('file_name'));
            }
            $document->delete();
            
            return response()->json(['data' => true]);
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
}
