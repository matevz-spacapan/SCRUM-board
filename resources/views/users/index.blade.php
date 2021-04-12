@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <div>{{ __('User Management') }}</div>
                    <div><a class="btn btn-link" href="{{ route('adminPage.index') }}" {{ Popper::arrow()->position('bottom')->pop('Go back to administrator dashboard.') }}>{{ __('Go back') }}</a></div>
                </div>
                <div class="card-body">
                    <a class="btn btn-success mb-2" href="{{ route('users.create') }}">{{ __('Create New User') }}</a>
                    
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                    @endif
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    @if($v == 'Administrator')
                                    <span class="lead"><span class="badge badge-danger">{{ $v }}</span></span>
                                    @else
                                    <span class="lead"><span class="badge badge-warning">{{ $v }}</span></span>
                                    @endif
                                @endforeach
                            @endif
                            </td>
                            <td>
                                {{--<!--<a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>-->--}}
                                <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                
                                
                                @if(empty($user->deleted_at))
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @else
                                    <!--{!! Form::open(['method' => 'PATCH','route' => ['users.update', $user->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Restore', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}-->
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $data->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
