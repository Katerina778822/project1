<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Analitics extends Model
{
    use HasFactory;
    protected $table = 'b24_analitics';
    protected $fillable = [
        'AIM','id_item','big_int1','big_int2','big_int3','big_int4','big_int5',
        'string1','string2','string3','string4','string5','double1','double2',
        'double3','double4','double5','text1','text2','text3','date1',
        'date2','date3','date4','date5','date6',
    ];

     //@ make notice to DB when contact isnt linked with company
     static public function whriteContactError(B24Contact $contact)
     {
 
         $var = B24Analitics::create([
             'AIM' => 4554,
             'date1' => $contact->DATE_CREATE,
             'string1' => $contact->ID,
             'string2' => $contact->NAME,
         ]);
     }
     //@ delete all contact (without compatiy) errors
     static public function deleteContactError()
     {
         $errors = B24Analitics::where([
             ['AIM', 4554],
         ])->get();
         foreach($errors as $error){
             $error->delete();
         }
     }
}
