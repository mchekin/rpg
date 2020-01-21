<?php

namespace App\Http\Controllers\Auth;

use App\User as UserModel;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\Presentation\Http\CommandMappers\CreateUserCommandMapper;
use App\Http\Controllers\Controller;
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
     * @var CreateUserCommandMapper
     */
    private $mapper;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @param CreateUserCommandMapper $mapper
     */
    public function __construct(UserService $userService, CreateUserCommandMapper $mapper)
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
            'email' => 'required|string|email|max:255|unique:' . User::class .  ',email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return UserModel
     */
    protected function create(array $data)
    {
        $request = $this->mapper->map($data);

        return $this->userService->create($request);
    }
}
