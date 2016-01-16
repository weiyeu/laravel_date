Click here to reset your password: <a href="{{ $link = url('laravel_date/public/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
