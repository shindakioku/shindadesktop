<?php

namespace App\Services\User;

use App\Entities\Anime;
use App\Entities\Music;
use App\Entities\User;
use App\Entities\UserFavorite;
use Illuminate\Support\Collection;

class UserService implements UserContract
{
    /**
     * @param string $login
     * @param string $password
     * @param bool $auth
     * @return array|Collection
     */
    public function auth(string $login, string $password, bool $auth)
    {
        if (!($user = User::where('name', $login)->first())) {
            $user = $this->registerUser($login, $password);
        }

        if (!password_verify($password, $user->password)) {
            return [
                'response' => 'Проверьте правильность ввода пароля',
                'error_code' => 'user.incorrect_password',
            ];
        }

        $user->token = $this->generateToken();
        $user->update();

        {
            unset($user->password);
        };

        return $user;
    }

    /**
     * @param string $entity
     * @param int $entityId
     * @param int $userId
     * @return array|bool
     */
    public function addFavorite(string $entity, int $entityId, int $userId)
    {
        {
            $entity = 'anime' == mb_strtolower($entity) ? Anime::class : Music::class;

            $hasEntityId = (Anime::where('id', $entityId)->select('id')->first()) 
                || 
                    (Music::where('id', $entityId)->select('id')->first());
        };

        if (!$hasEntityId) {
            return [
                'response' => 'Не корректное айди для entity',
                'error_code' => 'user.favorite.incorrect_entity',
            ];
        }

        if (!User::findOrFail($userId)) {
            return [
                'response' => 'Не корректный айдишник юзера',
                'error_code' => 'user.favorite.incorrect_user_id',
            ];
        }

        if (($user = UserFavorite::where('entity', $entity)->where('entity_id', $entityId)->where('user_id', $userId)->first())) {
            $user->delete();

            return false;
        }
        
        $user = new UserFavorite();

        $user->entity = $entity;
        $user->entity_id = $entityId;
        $user->user_id = $userId;

        $user->save();

        return true;
    }

    /**
     * @param int $id
     * @param string $entity
     * @return array|bool
     */
    public function getFavorite(int $id, string $entity)
    {
        if (!User::findOrFail($id)) {
            return false;
        }

        $result = [];
        $collection = UserFavorite::where('user_id', $id)->get();

        if ('anime' == mb_strtolower($entity)) {
            foreach ($collection as $k => $v) {
                $result[] = $v->anime;
            }
        } else {
            foreach ($collection as $k => $v) {
                $result[] = $v->music;
            }
        }

        return $result;
    }

    /**
     * @param int $userId
     * @param string $entity
     * @param int $entityId
     * @return bool
     */
    public function hasFavorite(int $userId, string $entity, int $entityId): bool
    {
        {
            $entity = 'anime' == mb_strtolower($entity) ? Anime::class : Music::class;
        };

        if (UserFavorite::where('user_id', $userId)->where('entity_id', $entityId)->where('entity', $entity)->first()) {
            return true;
        }

        return false;
    }

    /**
     * @param string $login
     * @param string $password
     * @return User
     */
    private function registerUser(string $login, string $password) // :User
    {
        $user = new User();

        $user->name = $login;
        $user->password = password_hash($password, PASSWORD_DEFAULT);

        $user->save();

        return $user;
    }

    /**
     * @param string $charset
     * @return string
     */
    private function generateToken($charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'): string
    {
        $length = 20;
        $str = '';
        $count = strlen($charset);

        while ($length--) {
            $str .= $charset[mt_rand(0, $count - 1)];
        }

        return $str;
    }
}