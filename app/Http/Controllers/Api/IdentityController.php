<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Exception\UnexpectedValueException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IdentityController extends Controller
{
    //
    public function authenticate_TC(Request $request){

        try {
            $validator = Validator::make($request->all(),[
                "identity_no" => "required | numeric",
                "name" => "required",
                "surname" => "required",
                "birthday" => "required | date_format:Y-m-d",
            ]);

            if($validator->fails()){
                throw new InvalidArgumentException($validator->errors()->first(),400);
            }

            $year = Carbon::createFromFormat('Y-m-d', $request->birthday)->year;

            $tckimlikno = new \Teknomavi\NVI\TCKimlikNo();
            $response   = $tckimlikno->dogrula($request->identity_no, $request->name, $request->surname, $year);

            if (!$response) {
                throw new BadRequestException("Doğrulama Başarısız",404);
            }
        } catch ( \SoapFault $e ) {
            return response()->json(["error" => [ "message" => "NVI Servisinde bir hata oluştu: " . $e->getMessage()]],500);
        } catch ( \Teknomavi\NVI\Exception\InvalidTCKimlikNo $e ) {
            return response()->json(["error" => [ "message" => "Girdiğiniz T.C. Kimlik Numarası geçersiz: " . $e->getMessage()]],400);
        } catch ( \InvalidArgumentException $e ) {
            return response()->json(["error" => [ "message" => "Bir Hata Oluştu: "  . $e->getMessage()]],400);
        } catch ( BadRequestException $e ) {
            return response()->json(["error" => [ "message" => ""  . $e->getMessage()]],400);
        }catch ( \Exception $e ) {
            return response()->json(["error" => [ "message" => "Bir Hata Oluştu: "  . $e->getMessage()]],500);
        }

        return response()->json(["message"=>"Doğrulama Başarılı"],400);
    }
}
