<?php

class User extends Page {

    public function __construct(string $path = null, array $lot = []) {
        parent::__construct($path, $lot);
    }

    public function __toString() {
        if (is_string($v = parent::get('author'))) {
            return $v;
        }
        return (string) $this->user();
    }

    public function URL(...$lot) {
        $n = $this->exist ? parent::name() : null;
        return $n ? $GLOBALS['url'] . State::get('x.user.path') . '/' . $n : null;
    }

    public function user() {
        return $this->exist ? '@' . parent::name() : null;
    }

}