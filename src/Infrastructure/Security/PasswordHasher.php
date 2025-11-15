<?php
// src/Infrastructure/Security/PasswordHasher.php

namespace EletronicoVerde\Infrastructure\Security;

class PasswordHasher
{
    //Cria hash da senha
    public function hash(string $senha): string
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    //Verifica se senha corresponde ao hash
    public function verify(string $senha, string $hash): bool
    {
        return password_verify($senha, $hash);
    }

    //Verifica se hash precisa ser atualizado (rehash)
    public function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT);
    }
}