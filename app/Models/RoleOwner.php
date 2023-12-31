<?php

/**
 * RoleAdmin Model
 *
 * RoleAdmin Model manages RoleAdmin operation.
 *
 * @category   RoleAdmin
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RoleOwner extends Model
{
    protected $table     = 'role_owner';
    protected $fillable  = ['role_id', 'owner_id'];
    public $timestamps   = false;

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.role_owner');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.role_owner', $data);
        }
        return $data;
    }
}
