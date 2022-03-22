@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row">
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
		<div class="col-md-2"></div>
		<div class="col-md-8 text-center">
			<h5  style="font-size: 18px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO SOCIAL</h5> 
			<p style="margin-right: -605px;"><a href="{{route('estatutoNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
			<ul class="list-group" style="font-size: 13px; margin-top: 25px;">
				@foreach($estatutos as $estatuto)
				<li class="list-group-item d-flex justify-content-between align-items-center border-top" style="background-color: #fafafa">
				<table>  
				  <tr>
					<td WIDTH="500"> <strong>{{$estatuto->name}}</strong> </td>
			    	<td> <a href="{{asset('storage/')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm" style="font-size: 12px;">Download <i class="fas fa-file-download" style="margin-left: 5px;"></i></a> </td>
					<td> &nbsp; </td>
					<td> <center> <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('estatutoExcluir', array($unidade->id, $estatuto->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
				  </tr>
				</table>
			  	</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

@endsection