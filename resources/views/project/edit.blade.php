@extends('layouts.app')

@section('title', __(' - Edit Project'))

@section('content')


<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                {{ __('Create new project') }}
                </div>
                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                    {!! Form::open(array('route' => 'project.update','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Project name:</strong>
                                {!! Form::text('project_name', null, array('placeholder' => 'Project name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Select project owner:</strong>
								<select id="s2n1" class="form-control"   name="project_owner">
									<option value='0'>-- Select user --</option>
								</select>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Select project master:</strong>
								<select id="s2n2" class="form-control"   name="project_master">
									<option value='0'>-- Select user --</option>
								</select>
							</div>
						</div>
						
						<hr class="w-100">
						
						@foreach ($developers as $developer)
							<div id="pud_{i}" class="pud col-xs-12 col-sm-12 col-md-12">
								<div class="form-group">
									<label>Developer:</label>
									<input type="text" id="input_pud_{i}" class="form_control" name="name_pud_{i}" disabled value="">
								</div>
								<button id="remove_user_btn_{i}" class="remove_user_btn btn btn-secondary" onClick="remove_user_fun(this.id)" type="button">Remove  developer</button>
								<hr class="w-100">
							</div>
							<hr class="w-100">
						@endforeach
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Search user:</strong>
								<select id="s2n3" class="form-control">
									<option value='0'>-- Select user --</option>
								</select>
								

							</div>
							<button id="add_user_btn" class="btn btn-secondary" type="button">Add as developer</button>
							
						</div>
						<hr class="w-100">
						
						
						<div id="p_dev_div">
						</div>
						
						<!--
						
						<div id="pud_i" class="pud col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Developer i:</label>
                                <input type="text" id="input_pud_i" name="name_pud_i" disabled value="">
                            </div>
                        </div>
						-->						

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            
                        </div>
						
                    </div>
                 </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection