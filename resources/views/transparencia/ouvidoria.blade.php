@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">SERVIÇO DE INFORMAÇÃO AO CLIENTE - SIC <i class="fas fa-globe"></i></h5>
			@if(Auth::check())
			<p style="margin-right: -980px; margin-top: -30px;"><a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('sicCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i> </a></p>
			@endif
		</div>
	</div>	<br>
	<div class="row">
		@if($unidade->id == 7 || $unidade->id == 4 || $unidade->id == 3 || $unidade->id == 6)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong> <a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong> </td>
		 </tr>
		</table>
		@elseif($unidade->id == 2 || $unidade->id == 5 || $unidade->id == 8)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></td>
		 </tr>
		</table>
		@endif
		
		@if($unidade->id == 1)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
		  
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong><a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong> </td>
		  
		  <td align="center"> <strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></td>
		 </tr>
		</table>		
		@endif
		
	</div> <br> <br>
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">OUVIDORIA:</h5> <br>
			@if($unidade->id == 2 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>Hospital da Mulher do Recife</strong></td>
				</tr>  
		        <tr>
				 <td> Responsável: <strong>Roberta Nayara</strong></td>
				</tr>
				<tr>
				 <td> Email: <strong>ouvidoria@hmr.org.br  </strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)2011-0100 / Ramal(207)  </strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 3 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
		        <tr>
				 <td> Unidade: <strong>UPAE Belo Jardim</strong></td>
				</tr>
		        <tr>
				 <td> Responsável: <strong>Géssica Tarcielma</strong></td>
				</tr>
				<tr>
				 <td> Email: <strong>ouvidoria@upaebelojardim.org.br  </strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)3726-8839  </strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 4 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>UPAE Arcoverde</strong></td>
				</tr>     
			    <tr>
			     <td> Responsável: <strong>Maryliani Ordonho Alves</strong></td>
			    </tr>
		        <tr>
				 <td> Email: <strong>ouvidoria@upaearcoverde.org.br</strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(87)3821-8008 / (87)3821-8024 / (87)99178-6768 </strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 5 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
		        <tr>
				 <td> Unidade: <strong>UPAE Arruda</strong></td>
				</tr>
		        <tr>
				 <td> Email: <strong>ouvidoria@upaearruda.org.br</strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)2011-0209 </strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 6 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>UPAE Caruaru</strong></td>
				</tr>     
			    <tr>
			     <td> Responsável: <strong>Luana Ruthiele</strong> </td>  
			    </tr>     
		        <tr>
				 <td> Email: <strong>ouvidoria@upaecaruaru.org.br</strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)3725-7552</strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 7 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>Hospital São Sebastião</strong></td>
				</tr>     
		        <tr>
				 <td> Email: <strong>ouvidoria@hss.org.br  </strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)3721-3500 - Ramal(4021) </strong></td>
				</tr>
		      </table>
			@endif
			@if($unidade->id == 8 || $unidade->id == 1)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>Hospital de Campanha Aurora</strong></td>
				</tr>     
		        <tr>
				 <td> Email: <strong>ouvidoria.hpr1@hcpgestao.org.br</strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong>(81)3447-9722 </strong></td>
				</tr>
		      </table>
			@endif
		</div>
	</div>	
</div>
@endsection