Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()).'&user_type='.$user->user_type }}"> {{ $link }} </a>
