<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use AppHttpRequestsRegisterAuthRequest;
use TymonJWTAuthExceptionsJWTException;
use SymfonyComponentHttpFoundationResponse;
use JWTAuth;
use Validator;
use AppUser;
use IlluminateHttpRequest;
use PhpParser\Node\Stmt\TryCatch;
use Response;
use Illuminate\Support\Facades\Auth;

class JwtAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), 
            [ 
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required', 
            ]);  

            if ($validator->fails()) {  
                return response()->json(['error'=>$validator->errors()], 401); 
            }   
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function login(Request $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            $token = null;
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function getUser(){
        try{
            return response()->json([
                'success' => true,
                'data' => User::all()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
