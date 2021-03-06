<form action="<?= $url . ($state->x->user->guard->path ?? $state->x->user->path ?? '/user') . $url->query('&amp;'); ?>" class="form-user form-user:enter" method="post" name="user" target="_top">
  <?php

  $some = $users->count() > 1;
  $tasks = [
      'alert' => $alert,
      'user' => $some ? [
          0 => 'p',
          1 => (new HTML([
              0 => 'input',
              1 => false,
              2 => [
                  'autofocus' => true,
                  'class' => 'input width',
                  'name' => 'user[key]',
                  'placeholder' => i('User'),
                  'type' => 'text'
              ]
          ])),
          2 => [
              'title' => i('User')
          ]
      ] : null,
      'pass' => [
          0 => 'p',
          1 => (new HTML([
              0 => 'input',
              1 => false,
              2 => [
                  'autofocus' => $some ? true : null,
                  'class' => 'input width',
                  'name' => 'user[pass]',
                  'placeholder' => i('Pass'),
                  'type' => 'password'
              ]
          ])),
          2 => [
              'title' => i('Pass')
          ]
      ]
  ];

  $tasks['tasks'] = [
      0 => 'p',
      1 => x\user\hook('user-form-tasks', [[
          'enter' => [
              0 => 'button',
              1 => i('Enter'),
              2 => [
                  'class' => 'button',
                  'name' => 'user[v]',
                  'type' => 'submit',
                  'value' => 1
              ]
          ]
      ]], ' '),
      2 => []
  ];

  $tasks['token'] = '<input name="user[token]" type="hidden" value="' . Guard::token('user') . '">';

  if ($kick = Get::get('kick')) {
      $tasks['kick'] = '<input name="user[kick]" type="hidden" value="' . htmlspecialchars($kick) . '">';
  }

  ?>
  <?= x\user\hook('user-form', [$tasks]); ?>
</form>
