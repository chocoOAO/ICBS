<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ZCusKna1;
use App\Models\Contract;
use App\Models\ChickenImport;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'account',
        'name',
        'password',
        'password_unencrypted',
        'auth_type',
        'm_KUNAG'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static $auth_type = [
        'worker' => '業務員',
        'admin' => '管理員',
        'collaborator' => '場管理員',
        'super_admin' => '超級管理員',
    ];

    // 判斷使用者是否為管理員
    public function isAdmin()
    {
        return $this->auth_type === 'admin' || $this->auth_type === 'super_admin';
    }

    // 回傳使用者的權限
    public function getAuth_type()
    {
        return $this->auth_type;
    }

    public function getPermissions($index)
    {
        //01001100，回傳第index個字元
        return $this->permissions[$index];
    }

    public function getMName() {
        if ($this->m_KUNAG == null) {
            return null;
        }
        return ZCusKna1::where('m_KUNAG', $this->m_KUNAG)->first()->m_NAME;
    }
    public function getContract() {
        // if null select all
        if ($this->m_KUNAGs == null) {
            $contracts = Contract::all();
        } else {
            $contracts = Contract::where('m_KUNAG', $this->m_KUNAG)->get();
        }
        return $contracts;
    }
    public function getChickenImport() {
        // if null select all
        if ($this->m_KUNAGs == null) {
            $chicken_imports = ChickenImport::all();
        } else {
            $chicken_imports = ChickenImport::where('m_KUNAG', $this->m_KUNAG)->get();
        }
        return $chicken_imports;
    }

}
