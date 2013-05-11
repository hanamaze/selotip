<?php

class SuperUserFilter {

    public function filter() {
        $user = Sentry::getUser();

        if (!$user->isSuperUser()) {
            return Redirect::home()->withErrors('Super User Only');
        }

    }
}
