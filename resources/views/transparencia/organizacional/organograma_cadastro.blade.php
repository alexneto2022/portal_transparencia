@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">ARQUIVO DO ORGANOGRAMA</h5>
		</div>
	</div>
	<div class="d-flex justify-content-between">
		<div class="p-2">
			<a href="{{route('trasparenciaOrganizacional', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar<i class="fas fa-undo-alt"></i> </a>
		</div>
		<div class="p-2">
			<?php if (sizeof($arqOrgano) == 0) { ?>
				<a href="{{route('organogramaNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
			<?php } else { ?>
				<a href="{{route('organogramaNovo', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Substituir <i class="fas fa-check"></i> </a>
				<a class="btn btn-danger btn-sm" href="{{route('organogramaExcluir', $unidade->id)}}"><i class="bi bi-trash3"></i></a>
			<?php } ?>
		</div>
	</div>
	<?php if (sizeof($arqOrgano) > 0) { ?>
		<div class="embed-responsive embed-responsive-16by9">
			<iframe class="embed-responsive-item" src="{{asset('storage')}}/{{$arqOrgano[0]->file_path}}"></iframe>
		</div>
	<?php } ?>
</div>

@endsection