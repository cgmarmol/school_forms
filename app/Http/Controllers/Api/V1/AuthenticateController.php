<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use \Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\Transformers\UserTransformer;

/**
 * API Authentication Layer.
 *
 * @Resource("Authenticate", uri="/authenticate")
 */
class AuthenticateController extends Controller
{
  /**
   * Authenticate user by email/password
   *
   * Get a token.
   *
   * @Post("/login")
   * @Versions({"v1"})
   * @Transaction({
   *    @Request({"email": "abc@def.com", "password": "p@55w0rd"}, headers={"Accept": "application/vnd.orsatmax.v1+json"}),
   *    @Response(401, body={"error": "invalid_credentials"}),
   *    @Response(500, body={"error": "could_not_create_token"}),
   *    @Response(200, body={"token": "jwt_generated_token" })
   * })
   */
  public function login(Request $request)
  {

    $user = User::where('email', '=', $request->input('email'))
      ->where('password', '=', md5($request->input('password')))
      ->first();

    try {
      if(! $user instanceof User) {
        return response()->json(['error' => 'Invalid credentials.'], 401);
      }
      // create a token for the user
      if (! $token = JWTAuth::fromUser($user)) {
        return response()->json(['error' => 'Invalid credentials.'], 401);
      }
    } catch(JWTException $e) {
      // something went wrong whilst attempting to encode the token
      return response()->json(['error' => 'could_not_create_token'], 500);
    }

    // all good so return the token
    return response()->json(compact('token'));
  }

  public function token()
  {
    $token = JWTAuth::getToken();
    if(! $token) {
      return response()->json(['error' => 'token_not_provided'], 500);
    }

    try {
      $token = JWTAuth::refresh($token);
    } catch(TokenInvalidException $e) {
      return response()->json(['error' => 'token_is_invalid'], 500);
    }

    // all good so return the token
    return response()->json(compact('token'));
  }

  public function logout()
  {
    $token = JWTAuth::getToken();
    if(! $token) {
      return response()->json(['error' => 'Token not provided.'], 500);
    }

    return response()->json(['success' => JWTAuth::invalidate(JWTAuth::getToken())]);
  }

  public function user()
  {
    $user = app('Dingo\Api\Auth\Auth')->user();

    return $this->response->item(
      $user,
      new UserTransformer,
      ['key' => 'user']
    );
  }
}
