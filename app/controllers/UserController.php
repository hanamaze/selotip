<?php

class UserController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        echo "Hello Laravel";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // echo $id;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return Response
     */
    public function showUser($username)
    {
        return $username;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return Response
     */
    public function showCompany($username)
    {
        return $username;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return Response
     */
    public function showAcamedia($username)
    {
        return $username;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function register() {
        return View::make('users.register')
            ->with('title', 'Register')
        ;
    }

    public function newUser() {
        try
        {
            $rules = array(
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:5',
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator)
                ;
            }

            // Let's register a user.
            $user = Sentry::register(array(
                'email' => trim(Input::get('email')),
                'username' => trim(Input::get('username')),
                'password' => Input::get('password'),
                'activated' => true,
            ));
            $group = Sentry::getGroupProvider()->findById(3);
            $user->addGroup($group);

            // Let's get the activation code
            $activationCode = $user->getActivationCode();
            echo $activationCode;

            // Send activation code to the user so he can activate the account
            // Mail::send('emails.welcome', $data, function($m)
            // {
            //     $m->to($user->email, $user->username)->subject('Welcome! Aktifin dulu yaa');
            // });

            return Redirect::route('login')->with('success', 'Berhasil. Jangan lupa diaktivasi dulu kk ^_^, baru login.');
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $errors = 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            $errors = 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $errors = 'User with this login already exists.';
        }
    }

    public function newGroup() {
        try
        {
            // Create the group
            $group = Sentry::getGroupProvider()->create(array(
                'name'        => 'Users',
                'permissions' => array(
                    'admin' => 1,
                    'users' => 1,
                ),
            ));
        }
        catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
        {
            echo 'Name field is required';
        }
        catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            echo 'Group already exists';
        }
    }

    public function getLogin() {
        return View::make('users.login')
            ->with('title', 'Login')
            ;
    }

    public function postLogin() {

        try {
            $user = DB::table('users')
                ->select('id')
                ->where('username', Input::get('username'))
                ->orwhere('email', Input::get('username'))
                ->first()
                ;

            if (!$user) {
                throw new Cartalyst\Sentry\Users\UserNotFoundException;
            }

            $user = Sentry::getUserProvider()->findById($user->id);

            if ($user->checkPassword(Input::get('password'))) {
                Sentry::login($user, false);
                return Redirect::home();
            } else {
                throw new Cartalyst\Sentry\Users\WrongPasswordException;
            }
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $errors = 'Salah password';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $errors = 'User tidak ditemukan';
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $errors = 'User belum aktif';
        }


        // TODO: Harusnya bisa redirect ke halaman terakhir yang dia buka.
        return Redirect::back()->withInput()->withErrors(@$errors);
    }

    public function activation() {

    }

    public function logout() {
        Sentry::logout();
        return Redirect::home();
    }

    public function adminIndex($groupId = 2) {
        if ($groupId == 0) {

        }

        // $group = Sentry::getGroupProvider()->findById($groupId);
        // $users = Sentry::getUserProvider()->findAllInGroup($group);

        $users = DB::table('users');
        $perPage = 20;
        $total = count($users->get());
        $users = $users->take($perPage)->skip(Request::get('page'))->get();
        // $users = User::where('username', 'root')->get();

        // pr($users);

        $pagination = Paginator::make($users, $total, $perPage);


        return View::make('admin.users.index')
            ->with('title', 'Manage Users')
            ->with('users', $users)
            ->with('pagination', $pagination)
        ;
    }

    public function adminPermission($id) {
        $user = Sentry::getUserProvider()->findById($id);

        return View::make('admin.users.permission')
            ->with('title', 'Admin - Permission')
            ->with('user', $user)
        ;
    }

    public function adminGroup($id = '') {
        $groups = Sentry::getGroupProvider()->findAll();

        return View::make('admin.users.groups')
            ->with('title', 'Admin - Groups')
            ->with('groups', $groups)
        ;
    }

    public function adminGroupEdit($id) {
        $group = Sentry::getGroupProvider()->findById($id);


        return View::make('admin.users.edit_group')
            ->with('title', 'Admin - Edit Group ' . $group->id)
            ->with('group', $group)
            ->with('is_superuser', array_key_exists('superuser', $group->getPermissions()))
        ;
    }

    public function adminGroupUpdate($id) {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $oldname = $group->name;
            $group->name = Input::get('name');

            if ($group->save())
            {
                $message = sprintf('Data udah di-update kk. dari <strong>%s</strong> ke <strong>%s</strong>.', $oldname, $group->name);
                return Redirect::back()
                    ->with('success', $message)
                ;
            } else {
                return Redirect::back()
                    ->with('errors', 'Something wrong :(')
                ;
            }

        }
        catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            echo 'Group already exists.';
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            echo 'Group was not found.';
        }
    }

    public function profile() {

        $user = Sentry::getUser();

        return View::make('users.profile')
            ->with('title', sprintf('%s %s Profile', $user->first_name, $user->last_name))
            ->with('user', $user)
        ;
    }

    public function updateProfile() {
        try
        {
            $user = Sentry::getUser();
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');

            // TODO: Periksa lagi rules nya. Mungkin kita harus pakai GUMP.
            $rules = array(
                'email' => 'required|email',
                'first_name' => "required",
                // 'last_name' => 'regex:[A-z( )?]',
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator->messages())
                ;
            }

            if ($user->save()) {
                $message = sprintf('Data udah di-update kk.');
                return Redirect::back()
                    ->with('success', $message)
                ;
            } else {
                return Redirect::back()
                    ->withErrors('ahhaa')
                    ->withInput()
                ;
            }
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'User with this login already exists.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }

    }

    public function adminDeleteGroup($id)
    {
        try
        {
            // Find the group using the group id
            $group = Sentry::getGroupProvider()->findById($id);

            // IMPORTANT! Super Users Group tidak boleh dihapus
            if ($group->getPermissions('superuser')) {
                return Redirect::route('admin_manage_group')
                    ->withErrors('Super User tidak boleh dihapus.')
                ;
            }

            // Delete the group
            $group->delete();

            return Redirect::route('admin_manage_group')
                ->with('success', 'Group telah dihapus')
            ;
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            return Redirect::route('admin_manage_group')
                ->withErrors('Group was not found.')
            ;
        }
    }

    public function userList() {

        $users = User::where('activated', true)->paginate(10);

        // pr($users);

        return View::make('users.index')
            ->with('title', 'User List')
            ->with('users', $users)
        ;
    }

}
