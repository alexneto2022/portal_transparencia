@extends('layouts.useroc')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <link rel="stylesheet" type="text/css" href="resourcers\views\ordem_compra\style.css" media="screen" />
        <title>Portal da Transparencia - HCP</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
    @section('content')
        @if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
    	@endif
 <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade[0]->name}}</strong></div><br>
 <section id="unidades">
 <table>   
    <tr> 
        <td> 
            
        </td>
        <td>  
        </td>
    </tr>
  </table>       
    <div class="container" style="margin-top:05px; margin-bottom:10px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">ORDENS DE COMPRAS</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
   <form action = "{{\Request::route('procuraVisualizarOrdemCompra', $unidade[0]->id)}}" method="POST"> 
   <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <table class="table" style = "margin-left:-50px">
        <tr>    
            <td>
            <a class="btn btn-warning btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 120px; margin-bottom: 15px; height: 30px;" href="{{url('/home')}}"> Voltar <i class="fas fa-undo-alt"></i></a>     
    
        </td>
            <td> 
              <select class="custom-select mr-sm-2" style="width: 200px; margin-left: 10px;" id="funcao" name="funcao">
                  <option id="funcao" name="funcao" value="0">Selecione...</option>
                  <option id="funcao" name="funcao" value="1">Data de Solicitação</option>
                  <option id="funcao" name="funcao" value="2">Data de Autorização</option>
              </select> 
            </td>         
            <td><input type="date" id="data" name="data" class="form-control" style="width: 160px" ></td>
            <td> <select class="custom-select mr-sm-2" style="width: 220px" id="funcao2" name="funcao2">
                  <option id="funcao2" name="funcao2" value="0">Selecione...</option>
                  <option id="funcao2" name="funcao2" value="2">Número da Solicitação</option>
                  <option id="funcao2" name="funcao2" value="1">Fornecedor</option>
                  <option id="funcao2" name="funcao2" value="3">Produto</option>
            </select> 
            </td>     
            <td>
              <input id="text" name="text" type="text" class="form-control" style="width: 240px;" placeholder="...">
            </td>
            <td>
              <button type="submit" class="btn btn-primary" style="margin-right: 35px; height: 35px;" >Pesquisar  <i class="fas fa-search"></i></button>
            </td>
        </tr>   
    </table>
    </form> 
	<div class="container d-flex justify-content-between">
        <div class="row">
            <table class="table table-striped table-sm table-bordered" style="margin-left: -100px; width: 2500px;">
                <thead>
                 <tr>
                   <td colspan='2' width="110px;"><center> <b>Solicitação</b> </center></td>
                   <td colspan='15'><center><b>Ordens de Compra</b></center></td>
                 </tr>
                 <tr>
                    <td style="font-size: 13px"><b> Número </b></td>
                    <td style="padding-right: 50px; font-size: 13px"><b><center>Data</center> </b></td>
                    <td style="padding-right: 20px; font-size: 13px"><b><center>Nº</center></b></td>
                    <td style="padding-right: 00px; font-size: 13px"><b><center>Data Autorização</center></b></td>
                    <td style="padding-right: 160px; font-size: 13px"><b><center>Fornecedor</center></b></td>
                    <td style="padding-right: 30px; font-size: 13px"><b><center>CNPJ</center></b></td>
                    <td style="padding-right: 2px; font-size: 13px"><b><center>Quantidade</center></b></td>
                    <td style="padding-right: 45px; font-size: 13px"><b><center>Valor Total</center></b></td>
                    <td style="padding-right: 140px; font-size: 13px"><b><center>Produto</center></b></td>
                    <td style="padding-right: 120px; font-size: 13px"><b><center>Classificação Item</center></b></td>
                    <td style="padding-right: 5px; font-size: 13px"><b><center>Qtd. Recebida</center></b></td>
                    <td style="padding-right: 20px;font-size: 13px"><b><center>Total Recebido</center></b></td>
                    <td style="padding-right: 10px;font-size: 13px"><b><center>Nº Nota Fiscal</center></b></td>
                    <td style="padding-right: 10px;font-size: 13px"><b><center>Chave Acesso</center></b></td>
                    <td style="padding-right: 10px;font-size: 13px"><b><center>Código IBGE</center></b></td>
                    <td>Arquivos</td>
                  </tr>
                 </thead>
                   @foreach($processos as $prc)
                   <tr>
                    <td style = "font-size: 13px;" title="<?php echo $prc->numeroSolicitacao; ?>"><center> {{ $prc->numeroSolicitacao }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->dataSolicitacao; ?>">  <center> {{ $prc->dataSolicitacao }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->numeroOC; ?>"><center>{{ substr($prc->numeroOC,0,10) }}</center> </td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->dataAutorizacao; ?>"><center> {{ $prc->dataAutorizacao }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->fornecedor; ?>"> {{ (substr($prc->fornecedor, 0, 25)) }} </td>
                    <td style = "padding-right: 10px; font-size: 13px;"><center> {{ $prc->cnpj }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->qtdOrdemCompra; ?>">  <center> {{ $prc->qtdOrdemCompra }} </center></td>
                    <td style = "font-size: 13px;"><center> {{ "R$ ".number_format($prc->totalValorOC, 2,',','.') }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->produto; ?>"> {{ (substr($prc->produto, 0, 25)) }} </td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->classificacaoItem; ?>">  <center> {{ substr($prc->classificacaoItem,0,22) }} </center></td>
                    <td style = "font-size: 13px;"><center> {{ $prc->quantidadeRecebida }} </center></td>
                    <td style = "font-size: 13px;"><center> {{ "R$ ".number_format($prc->valorTotalRecebido, 2,',','.') }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->numeroNotaFiscal; ?>">  <center> {{ $prc->numeroNotaFiscal }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->chaveAcesso; ?>">  <center> {{ $prc->chaveAcesso }} </center></td>
                    <td style = "font-size: 13px;" title="<?php echo $prc->codigoIBGE; ?>">  <center> {{ $prc->codigoIBGE }} </center></td>
                    <td> 
                        <a class="badge badge-pill badge-outline-warning dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cloud-download"></i>
                        <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
                            @foreach($processo_arq as $prc_arq) 
                                @if($prc_arq->processo_id == $prc->id)
                                    <a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$prc_arq->file_path}}" target="_blank">{{ $prc_arq->title }}</a>
                                @endif
                            @endforeach
                        </div>	
                        </a>
                    </td>
                   </tr> 
                   @endforeach   
            </table>
            <table>
             <tr><td> {{ $processos->appends(['pesq' => isset($pesq) ? $pesq : ''])->render() }} </td></tr>
            </table>
        </div>
    </div>
</section >    
@endsection