@extends('navbar.default-navbar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">INSTITUCIONAL</h3>
        </div>
    </div>
	<form action="{{\Request::route('store',$unidade->id)}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-7" style="font-size: 13px;">  
            <table class="table-sm" style="line-height: 1.5;">
                <tbody>
	                 <tr>
                        <td style="border-top: none;"><strong>Perfil: </strong></td>
                        <td style="border-top: none;" id="txtPerfil">{{$unidade->owner}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CNPJ: </strong></td>
                        <td style="border-top: none;" id="txtCnpj">{{ preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})/", "\$1.\$2.\$3/\$4\$5-", $unidade->cnpj)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Nome Unidade: </strong></td>
                        <td style="border-top: none;" id="txtNome">{{$unidade->name}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Logradouro: </strong></td>
                        <td style="border-top: none;" id="txtLogradouro">{{$unidade->address}} , {{$unidade->numero == null ? ' s/n' : $unidade->numero}}</td>
				    </tr>
                    @if(isset($unidade->further_info) || $unidade->further_info !== null)
                    <tr>
                        <td style="border-top: none;"><strong>Complemento: </strong></td>
                        <td style="border-top: none;" id="txtComplemento">{{$unidade->further_info}}</td>
				    </tr>
                    @endif
                    <tr>
                        <td style="border-top: none;"><strong>Bairro: </strong></td>
                        <td style="border-top: none;" id="txtBairro">{{$unidade->district}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Cidade: </strong></td>
                        <td style="border-top: none;" id="txtCity">{{$unidade->city}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>UF: </strong></td>
                        <td style="border-top: none;" id="txtUf">{{$unidade->uf}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CEP: </strong></td>
                        <td style="border-top: none;" id="txtCep">{{preg_replace("/(\d{2})(\d{3})/", "\$1.\$2-", $unidade->cep)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Telefone: </strong></td>
                        <td style="border-top: none;" id="txtTelefone">{{preg_replace("/(\d{4})(\d{4})/", "\$1-\$2", $unidade->telefone)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Horário: </strong></td>
                        <td style="border-top: none;" id="txtHorario">{{$unidade->time}}</td>
				    </tr>
                    @if(isset($unidade->cnes) || $unidade->cnes !== null)
                    <tr>
                        <td style="border-top: none;"><strong>CNES: </strong></td>
                        <td style="border-top: none;" id="txtCnes">{{$unidade->time}}</td>
				    </tr>
                    @endif

                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div style="height: 30px;">
                <div class="h-25 d-inline-block" style="width: 120px;"></div>
            </div>
            <iframe src="{{$unidade->google_maps}}" width="400" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12"  style="font-size: 13px;">
            <table style="line-height: 1.5;">
                <tbody>
                    @if(isset($unidade->capacity) || $unidade->capacity !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity"><strong>Capacidade: </strong>{!! $unidade->capacity !!}</td>
				    </tr>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</tr>
                    @endif
                    @if(isset($unidade->specialty) || $unidade->specialty !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty"><strong>Especialidades: </strong>{!!$unidade->specialty!!}</td>
				    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
	
	<table>
		<tr>
			<td>
				<a href="{{route('trasparenciaHome', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			</td>
			<td> 
				<a class="btn btn-success btn-sm" style="margin-top: 10px;" href="{{route('institucionalAlterar', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
			</td>
			<td>
			    
			</td>
			<td>
				<a class="btn btn-danger btn-sm" href="{{route('institucionalExcluir', $unidade->id)}}" style="margin-top: 10px;">Excluir<i class="fas fa-times-circle"></i></a>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
</div>

@endsection
