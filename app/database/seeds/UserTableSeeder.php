<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        // Super Users
        $user = Sentry::getUserProvider()->create(array(
            'email'    => 'root@localhost.com',
            'first_name' => "ROOT",
            'last_name' => "ROOT",
            'username' => 'root',
            'password' => 'root',
            'activated' => true
        ));
        $adminGroup = Sentry::getGroupProvider()->findById(1);
        $user->addGroup($adminGroup);


        $user = Sentry::getUserProvider()->create(array(
            'email'    => 'admin@localhost.com',
            'first_name' => "Admin",
            'last_name' => "istrator",
            'username' => 'admin',
            'password' => 'demo123',
            'activated' => true
        ));
        $adminGroup = Sentry::getGroupProvider()->findById(2);
        $user->addGroup($adminGroup);


        $user = Sentry::getUserProvider()->create(array(
            'email'    => 'company@localhost.com',
            'first_name' => "Company",
            'last_name' => "PT ABC",
            'username' => 'company',
            'password' => 'demo123',
            'activated' => true
        ));
        $adminGroup = Sentry::getGroupProvider()->findById(4);
        $user->addGroup($adminGroup);


        $user = Sentry::getUserProvider()->create(array(
            'email'    => 'venture@localhost.com',
            'first_name' => "East Venture",
            'last_name' => "Venture",
            'username' => 'venture',
            'password' => 'demo123',
            'activated' => true
        ));
        $adminGroup = Sentry::getGroupProvider()->findById(5);
        $user->addGroup($adminGroup);

        $i = 0;
        while ($i <= 20) {
            $user = Sentry::getUserProvider()->create(array(
                'email'    => "user{$i}@localhost.com",
                'first_name' => "User {$i}",
                'username' => "user{$i}",
                'password' => 'demo123',
                'activated' => true
            ));
            $adminGroup = Sentry::getGroupProvider()->findById(3);
            $user->addGroup($adminGroup);
            $i++;
        }


        $i = 0;
        while ($i <= 20) {
            $user = Sentry::getUserProvider()->create(array(
                'email'    => "usera{$i}@localhost.com",
                'first_name' => "User A {$i}",
                'username' => "usera{$i}",
                'password' => 'demo123',
                'activated' => true
            ));
            $i++;
        }



    }

}
