<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'password', 'role'];
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        
        return $data;
    }
    
    public function verifyPassword($username, $password)
    {
        $user = $this->where('username', $username)->first();
        
        if (!$user) {
            log_message('debug', "verifyPassword: User '{$username}' not found");
            return false;
        }
        
        log_message('debug', "verifyPassword: User '{$username}' found, checking password");
        log_message('debug', "verifyPassword: Input password length: " . strlen($password));
        log_message('debug', "verifyPassword: Stored hash starts with: " . substr($user['password'], 0, 10));
        
        $passwordMatch = password_verify($password, $user['password']);
        log_message('debug', "verifyPassword: Password verification result: " . ($passwordMatch ? 'SUCCESS' : 'FAILED'));
        
        if ($passwordMatch) {
            return $user;
        }
        
        return false;
    }
}
