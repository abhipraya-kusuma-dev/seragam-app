<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
  public function readGudang(User $user)
  {
    return $user->role === 'admin-gudang' ? Response::allow() : Response::denyWithStatus(403, 'Situ kan bukan admin gudang bre');
  }

  public function readUkur(User $user)
  {
    return $user->role === 'admin-ukur' ? Response::allow() : Response::denyWithStatus(403, "Situ kan bukan admin ukur bre");
  }

  public function createGudang(User $user)
  {
    return $user->role === 'admin-gudang' ? Response::allow() : Response::denyWithStatus(403, 'Situ kan bukan admin gudang bre');
  }

  public function updateGudang(User $user)
  {
    return $user->role === 'admin-gudang' ? Response::allow() : Response::denyWithStatus(403, 'Situ kan bukan admin gudang bre');
  }

  public function deleteGudang(User $user)
  {
    return $user->role === 'admin-gudang' ? Response::allow() : Response::denyWithStatus(403, 'Situ kan bukan admin gudang bre');
  }

  public function createUkur(User $user)
  {
    return $user->role === 'admin-ukur' ? Response::allow() : Response::denyWithStatus(403, "Situ kan bukan admin ukur bre");
  }

  public function updateUkur(User $user)
  {
    return $user->role === 'admin-ukur' ? Response::allow() : Response::denyWithStatus(403, "Situ kan bukan admin ukur bre");
  }

  public function deleteUkur(User $user)
  {
    return $user->role === 'admin-ukur' ? Response::allow() : Response::denyWithStatus(403, "Situ kan bukan admin ukur bre");
  }
}
