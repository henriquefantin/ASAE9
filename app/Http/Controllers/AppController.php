<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLogin;
use Auth;
class AppController extends Controller
{
    function tela_login(){
    	//Exibir tela de login
    	return view('passwords/login');
    }

    function tela_cadastro(){
        //Exibir tela de login
        return view('tela_cadastro_usuario');
    }

    function adicionar(Request $req){
        $nome = $req->input('nome');
        $login = $req->input('login');
        $senha = $req->input('senha');

        $usuario_login = new UserLogin();
        $usuario_login->nome = $nome;
        $usuario_login->login = $login;
        $usuario_login->senha = $senha;

        if ($usuario_login->save()){
            $msg = "Usuário $nome adicionado com sucesso.";
        } else {
            $msg = "Usuário não foi cadastrado.";
        }

        return view("retorno", [ "mensagem" => $msg ]);
    }

    function login(Request $req){
    	//Comparar usuário e senha
    	$login = $req->input('login');
    	$senha = $req->input('senha');

    	$usuario_login = UserLogin::where('login', '=', $login)->first();
    	// $usuario terá null ou os dados do usuario encontrado

    	if ($usuario_login and $usuario_login->senha == $senha){
    		//se nao é null, entra aqui
    		//login e senha estão certos

            $variavel = [
                "login" => $login,
                "nome" => $usuario_login->nome
            ];
            session($variavel);

    		return redirect()->route('listar');
    	} else {
    		return view("retorno", ["mensagem" => "Usuário ou senha inválidos."]);
    	}
    }

    function logout(){
       Auth::logout();
        return redirect()->route('login');
    }
}
