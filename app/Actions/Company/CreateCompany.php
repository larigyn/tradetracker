<?php

namespace App\Actions\Company;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CreateCompany
{
    public function execute($data)
    {

        $user = DB::table('users')->where('id', $data['user_id'])->get();
        $logoName = time() . '.' . $data['logo']->getClientOriginalExtension();
        $logo = $data['logo']->move(public_path('logo'), $logoName);

        $company = new Company([
            'name'          =>  $$data['name'],
            'description'   =>  $data['description'],
            'address'       =>  $data['address'],
            'logo'          =>  $logo
        ]);

        $user->companies()->save($company);

        return $user;
    }
}
