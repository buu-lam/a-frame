<?php

namespace Af\System\Raw;

class Session {

    public function start($options = []): bool {
        return session_start($options);
    }

    public function id(?string $id = null): string|false {
        return session_id($id);
    }

}
