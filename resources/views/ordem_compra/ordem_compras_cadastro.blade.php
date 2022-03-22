@extends('layouts.app')
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
 
 <section id="unidades">
 <table>   
    <tr> 
        <td> 
          <a class="btn btn-warning btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 120px; margin-bottom: 15px; height: 30px;" href="{{url('/home')}}"> Voltar <i class="fas fa-undo-alt"></i></a>     
        </td>
        <td>  
          <a class="btn btn-dark  btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 980px; margin-bottom: 15px; height: 28px;" href="{{route('transparenciaOrdemCompraNovoArquivo', $unidade[0]->id)}}" > Novo <i class="fas fa-check"></i></a>    
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
   <form action = "{{\Request::route('procuraOrdemCompra', $unidade[0]->id)}}" method="POST"> 
   <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <table class="table" style = "margin-left:-50px">
        <tr>    
            <td> 
              <select class="custom-select mr-sm-2" style="width: 200px; margin-left: 150px;" id="funcao" name="funcao">
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
            <table class="table table-striped table-sm table-bordered" style="margin-left: -100px; width: 1340px;">
                <thead>
                 <tr>
                   <td colspan='2' width="110px;"><center> <b>Solicitação</b> </center></td>
                   <td colspan='15'><center><b>Ordens de Compra</b></center></td>
                 </tr>
                 <tr>
                    <td style="font-size: 13px"><b> Número </b></td>
                    <td style="padding-right: 60px; font-size: 13px"><b> <center>Data</center> </b></td>
                    <td style="padding-right: 25px; font-size: 13px"><b> Número O.C </b></td>
                    <td style="padding-right: 20px; font-size: 13px"><b> Data Autorização </b></td>
                    <td style="padding-right: 160px; font-size: 13px"><b><center> Fornecedor </center></b></td>
                    <td style="padding-right: 110px; font-size: 13px"><b><center> CNPJ </center></b></td>
                    <td style="padding-right: 140px; font-size: 13px"><b> Produto </b></td>
                    <td style="padding-right: 5px; font-size: 13px"><b> Qtd. Recebida </b></td>
                    <td style="padding-right: 10px;font-size: 13px"><b> Total Recebido </b></td>
                    <td style="padding-right: 1px; font-size: 13px"> <b>Opções</b></td>
                    <td style="padding-right: 1px; font-size: 13px"> <b>Arquivos</b></td>
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
                    <td style = "font-size: 13px;" title="<?php echo $prc->produto; ?>"> {{ (substr($prc->produto, 0, 25)) }} </td>
                    <td style = "font-size: 13px;"><center> {{ $prc->quantidadeRecebida }} </center></td>
                    <td style = "font-size: 13px;"> {{ "R$ ".number_format($prc->valorTotalRecebido, 2,',','.') }} </td>
                    <td> 
                      <div class="dropdown">
                        <a class="btn btn-outline-info" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-caret-down"></i>               
                        </a>
                       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a title="Alterar" class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{ route('ordemCompraAlterar', array($unidade[0]->id, $prc->id)) }}" > <i class="fas fa-edit"></i></a>
                        <a title="Excluir" class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('ordemCompraExcluir', array($unidade[0]->id, $prc->id))}}" ><i class="fas fa-times-circle"></i></a> </center>
                        <a title="Add Arquivos" class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{route('arquivosOrdemCompra', array($unidade[0]->id, $prc->id))}}" ><i class="fa fa-file-o" ></i></a> </center>
                       </div>
                      </div>
                    </td>
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