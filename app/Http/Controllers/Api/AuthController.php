<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function response;

class AuthController extends Controller
{
    /**
     * @param mixed $getToken
     * @return JsonResponse|null
     */
    public function index($getToken) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json(User::all());
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @return JsonResponse|null
     */
    public function create($getToken) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json('');
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
            return response()->json('');
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @param int   $id
     * @return JsonResponse|null
     */
    public function edit($getToken, $id) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json('');
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @param int   $id
     * @return JsonResponse|null
     */
    public function update($getToken, $id) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json('');
        }
        
        return response()->json(['invalid token'], 403);
    }
    
    /**
     * @param mixed $getToken
     * @param int   $id
     * @return JsonResponse|null
     */
    public function destroy($getToken, $id) : ?JsonResponse
    {
        if ($this->tokenCheck($getToken)->getData(true)['data'] === true) {
            return response()->json('');
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
