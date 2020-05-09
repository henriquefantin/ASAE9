<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Venda;
use App\Produto;

class VendaController extends Controller
{
    function telaCadastroVendas(){
        
            $usuarios = Usuario::all();
            return view("venda_cliente", ["usuarios" => $usuarios]);
         
    }

    function adicionar(Request $req){
      
            $id_cliente = $req->input('id_cliente');
    	#$descricao = $req->input('descricao');
    	#$valor = $req->input('valor');
    	
    	$venda = new Venda();
        $venda->valor = 0;# $valor;
        $venda->id_cliente = $id_cliente;
    	
    	if ($venda->save()){
            $msg = "Venda adicionada com sucesso.";
        } else {
            $msg = "Venda não foi cadastrada.";
        }

        return redirect()->route('vendas_item_novo', ['id' => $venda->id]);
    	//return view("retorno_venda", [ "mensagem" => $msg ]);
        
    }

    function listar(){
      
        	$vendas = Venda::all();
            return view('lista_vendas_geral', [ 'venda' => $vendas ]);
      
    }

    function itensVenda($id){
        $venda = Venda::find($id);
        return view('lista_itens_venda', ['venda' => $venda]);
    }

    function telaAdicionarItem($id){
        $venda = Venda::find($id);
        $produtos = Produto::all();
        return view('tela_cadastro_itens', ['venda' => $venda, 'produtos' => $produtos]);
    }

    function adicionarItem(Request $req, $id){
        $id_produto = $req->input('id_produto');
        $quantidade = $req->input('quantidade');
        $produto = Produto::find($id_produto);
        $venda = Venda::find($id);
        $subtotal = $produto->preco * $quantidade;

        $colunas_pivot = [
            'quantidade' => $quantidade,
            'subtotal' => $subtotal
        ];
        $venda->produtos()->attach($produto->id, $colunas_pivot);
        $venda->valor += $subtotal;
        $venda->save();

        return redirect()->route('vendas_item_novo', ['id' => $venda->id]);
    }

    function excluirItem($id, $idProduto){
        $venda = Venda::find($id);
        $subtotal = 0;
        foreach ($venda->produtos as $vp) {
            if($vp->id == $idProduto){
                $subtotal = $vp->pivot->subtotal;
                break;
            }
        }
        $venda->valor = $venda->valor - $
        $venda->save();
        $venda->produtos()->datach($id_produto);

        return redirect()->rout('vendas_item_novo', ['id' => $id]);
    }
}
