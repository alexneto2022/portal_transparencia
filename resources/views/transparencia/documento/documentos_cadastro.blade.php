@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" >
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">DOCUMENTAÇÃO DE REGULARIDADE</h5>
			<p style="margin-right: -780px"> <a href="{{route('documentosNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>		 </p>
		</div>
	</div>	
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
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
					<div id="{{$type->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
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
												<td class="border-0 text-justify align-middle" style="font-size: 13px;">{{$docs->name}}</td>
												<td class="border-0 align-middle"><i class="fas fa-arrow-right"></i></td>
												<td class="border-0 align-middle"><a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a></td>
												<td class="border-0 align-middle"><a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('documentosExcluir', array($unidade->id, $docs->id))}}" ><i class="fas fa-times-circle"></i></a></td>
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
		</dir>
		<div class="col-md-1"></div>
	</dir>
</div>

@endsection