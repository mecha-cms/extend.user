<?php namespace fn\user;

// Require the plug manually…
\r(['get', 'is'], __DIR__ . DS . 'engine' . DS . 'plug', \Lot::get(null, []));

// Store user state to registry…
$state = \Extend::state('user');
if (!empty($state['user'])) {
    \Config::alt(['user' => $state['user']]);
}

function author($author = "") {
    if (is_string($author) && strpos($author, '@') === 0) {
        return new \User(USER . DS . substr($author, 1) . '.page');
    }
    return $author;
}

function avatar($avatar, array $lot = []) {
    if ($avatar) {
        return $avatar;
    }
    $w = array_shift($lot) ?? 72;
    $h = array_shift($lot) ?? $w;
    $d = array_shift($lot) ?? 'monsterid';
    return $GLOBALS['URL']['protocol'] . 'www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $w . '&amp;d=' . $d;
}

\Hook::set('*.author', __NAMESPACE__ . "\\author", 2);
\Hook::set('user.avatar', __NAMESPACE__ . "\\avatar", 0);

\Config::set('is.enter', $user = \Is::user());

\Lot::set([
    'user' => new \User($user ? USER . DS . substr($user, 1) . '.page' : null),
    'users' => new \Anemon
]);

// Apply route(s) only if we have at least one user
if (\g(USER, 'page')) {
    \Hook::set('on.ready', function(){
        \Lot::set('users', \Get::users()->map(function($v) {
            return new \User($v['path']);
        }));
    }, 0);
    include __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'worker' . DS . 'route.php';
}