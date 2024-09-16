<?php

namespace Kavenegar\KavenegarSms\Repositoties;

use App\Models\Verify;
use Illuminate\Support\Facades\DB;

class VerifyRepository
{


    /**
     * save code and phone to db.
     *
     * @param string $phone The Phone of the user to check.
     * @return string sent code.
     */
    public function storeCode($phone,$code):void
    {
        // Retrieve all records for the given user_id
        DB::table("verifies")->insert(
            [
                "phone" => $phone,
                "code" => $code,
                "created_at" => now(),
                "updated_at" => now(),
            ]
        );

    }
    /**
     * Check if a code has been sent to the user.
     *
     * @param int $phone The Phone of the user to check.
     * @return bool True if a code has been sent, otherwise false.
     */
    public function isCodeSend($phone)
    {
        // Retrieve all records for the given user_id
        $record = DB::table("verifies")->where("phone", $phone)->latest()->first();

        // If a record exists (i.e., a code has been sent), return true. Otherwise, return false.
        return $record ? true : false;
    }

    /**
     * Check if a code has been sent to the user within the last 60 seconds.
     *
     * @param int $phone The Phone of the user to check.
     * @return bool True if a code has been sent within the last 60 seconds, otherwise false.
     */
    public function canSendNewCode($phone)
    {
        // Retrieve the latest record for the given user_id based on the creation time
        $latestRecord =  DB::table("verifies")->where("phone", $phone)->latest()->first();
        $time = 30;

        // If a record exists and its creation time is within the last 60 seconds, return true.
        if (abs(now()->diffInSeconds($latestRecord->created_at)) >= $time) {
            return true;
        }

        // If no record exists or the latest record is older than 60 seconds, return false.
        return false;
    }

    public function deleteOldCode($phone)
    {
        return  DB::table("verifies")->where("phone",$phone)->delete();
    }
    public function verifyCode($phone,$code):bool
    {
        // Retrieve all records for the given user_id
        $record = DB::table("verifies")->where("phone", $phone)->latest()->first();
        if ($this->isCodeSend($phone))
        {
            return $record->code == $code;
        }else
        {
            return false;
        }

    }
}
