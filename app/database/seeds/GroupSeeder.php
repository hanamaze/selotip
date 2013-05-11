<?php

class GroupTableSeeder extends Seeder {

    public function run()
    {
        $groupProvider = Sentry::getGroupProvider();

        $groupProvider->create(array(
            'name' => 'Super Users',
            'permissions' => array('superuser' => 1),
            )
        );

        $groupProvider->create(array(
            'name' => 'Administrator',
            'permissions' => array('admin' => 1),
            )
        );

        $groupProvider->create(array(
            'name' => 'Users',
            'permissions' => array('users' => 1),
            )
        );

        $groupProvider->create(array(
            'name' => 'Companies',
            'permissions' => array(),
            )
        );

        $groupProvider->create(array(
            'name' => 'Ventures',
            'permissions' => array(),
            )
        );

    }

}
