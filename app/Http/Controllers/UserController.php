<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use phpOffice\phpWord\TemplateProcessor;
class UserController extends Controller
{
    public function index(){

        $users = User::all();
        return view('users.index',compact('users'));
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    public function wordExport($id){
        $user = User::findOrFail($id);
        $templateProcessor= new TemplateProcessor('word-template/user.docx');
        $templateProcessor->setValue('id', $user->id);
        $templateProcessor->setValue('name', $user->name);
        $templateProcessor->setValue('email', $user->email);
        $templateProcessor->setValue('address', $user->address);
        $fileName= $user->name;
        $templateProcessor->saveAs($fileName.'.docx');
        return response()->download($fileName.'.docx')->deletefileaftersend(true);



    }
}
