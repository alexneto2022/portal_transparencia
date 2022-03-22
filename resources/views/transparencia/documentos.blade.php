@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" >
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">DOCUMENTAÇÃO DE REGULARIDADE</h5>
			@if($unidade->id == 1)
			 @if(Auth::check())
			  @foreach ($permissao_users as $permissao)
			   @if(($permissao->permissao_id == 4) && ($permissao->user_id == Auth::user()->id))
				@if ($permissao->unidade_id == $unidade->id)
			      <p style="margin-right: -770px;"><a href="{{route('documentosCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			    @endif
			   @endif
			   @endforeach 
			 @endif
			@endif
		</div>
	</div>	
	<div class="row" style="margin-top: 0px;">
		<div class="col-md-1"></div>
		<div class="col-md-10 text-center">
			@foreach($types as $type)
			<div class="accordion border-0" id="accordionExample" >
				<div class="card">
				<div class="card-header border-0" id="headingOne" style="padding: 0px;">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#{{$type->id}}" aria-expanded="true" aria-controls="{{$type->id}}">
								{{$type->type_name}}
							</a>				
						</h5>
					</div>
					<div id="{{$type->id}}" class="collapse {{$escolha == $type->type_name? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<table class="table table-sm">
										<thead class="" >
										</thead>
										<tbody class="">
											@foreach($documents as $docs)
											@if($docs->type_id == $type->id)
											<tr>
												<td class="border-0 text-justify" style="font-size: 13px;">{{$docs->name}}</td>
												<td class="border-0 align-middle"><i class="fas fa-arrow-right"></i></td>
												<td class="border-0 align-middle"><a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a></td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
@endsection