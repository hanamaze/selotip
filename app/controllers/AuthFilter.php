<?php

class AuthFilter {
    public function filter() {
        if (!Sentry::check()) {
            return Redirect::route('login')->withErrors('Login dulu atuh');
        }
    }
}
