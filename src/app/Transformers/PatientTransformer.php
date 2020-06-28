<?php

namespace App\Transformers;

use App\Models\Patient;
use League\Fractal\TransformerAbstract;

class PatientTransformer extends TransformerAbstract
{
    public function transform(Patient $patient)
    {
        $countryName = $patient->country ? $patient->country->name : '';
        $fullName = $patient->getFullname();
        $nationalIdNumber = $patient->id_number;
        $dateOfBirth = $patient->date_of_birth?$patient->date_of_birth->format('d-m-Y'):'';
        $id = $patient->id;
        $importedName = $patient->imported_name;

        $displayName = $fullName?$fullName:($importedName?$importedName:'');

        $user = $patient->user?$patient->user->first():null;
        $userCustomData = $user?$user->pivot:null;

        return [
            'id' => $id,
            'full_name' => $fullName,
            'gender' => $patient->gender,
            'profile_image_url' => ($patient->profileImage) ? $patient->profileImage->getFullUrl() : Patient::getDefaultAvatarUrl(),
            'country_name' => $countryName,
            'id_number' => $nationalIdNumber,
            'text' => $nationalIdNumber . ' - ' . $displayName . ' - ' . $countryName . ' - ' . $dateOfBirth . ' - #' . $id,
            'email' => $patient->email,
            'phone_country_code' => $patient->phone_country_code,
            'phone_number' => $patient->phone_number,
            'date_of_birth' => $dateOfBirth,
//            'users' => $patient->users
            'account' => $patient->account,
            'imported_name' => $patient->imported_name,
            'imported_email' => $patient->imported_email,
            'imported_phone' => $patient->imported_phone,
            'user' => $userCustomData,
        ];
    }
}
