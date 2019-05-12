<?php

namespace App\Http\Controllers\Auth;

use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\Presentation\Http\RequestMappers\CreateUserRequestMapper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CreateUserRequestMapper
     */
    private $mapper;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @param CreateUserRequestMapper $mapper
     */
    public function __construct(UserService $userService, CreateUserRequestMapper $mapper)
    {
        $this->middleware('guest');

        $this->userService = $userService;
        $this->mapper = $mapper;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $request = $this->mapper->map($data);

        $user = $this->userService->create($request);

        /** @var User $userModel */
        $userModel = $user->getModel();

        return $userModel;
    }
}
