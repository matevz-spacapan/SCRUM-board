@extends('layouts.app')

@section('title', __(' - Project tasks'))

@section('page_specific_scripts')
    <script>
        function delete_work(work, button) {
            axios.delete('/work/' + work.id)
                .then(() => $(button).parent().parent().css("display", "none"));
        }

        function edit_work(work, button) {
            const work_id = work.id;
            const time_estimate_button = $('tr[work=' + work_id + '] td.estimate-field input');
            const amount_button = $('tr[work=' + work_id + '] td.amount-field input');

            if (!amount_button.prop('disabled')) {
                work.amount_min = Math.floor(amount_button.val() * 60);
                work.time_estimate_min = Math.floor(time_estimate_button.val() * 60);

                if (work.amount_min > work.time_estimate_min) {
                    time_estimate_button.addClass('is-invalid');
                    return;
                }

                axios.put('/work/' + work.id, work)
                    .then(() => {
                        $(button).text('Edit work');
                        amount_button.removeClass('is-invalid');
                        time_estimate_button.removeClass('is-invalid');

                        amount_button.prop('disabled', true);
                        time_estimate_button.prop('disabled', true);
                    })
                    .catch(() => {
                        amount_button.addClass('is-invalid');
                        time_estimate_button.addClass('is-invalid');
                    })
            } else {
                $(button).text('Submit edit');
                amount_button.prop('disabled', false);
                time_estimate_button.prop('disabled', false);
            }
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline">
                        <div>{{ __('Work done on task: ' . $task->description) }}</div>
                        <div><a class="btn btn-link"
                                href="{{ route('task.task_view', $project->id) }}" {{ Popper::arrow()->position('right')->pop('Return to the task view') }}>{{ __('Go back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Day</th>
                                <th>Time estimate [h]</th>
                                <th>Amount worked [h]</th>
                                @if($task->accepted !== 3 && ($task->user && $task->user->id === Auth::user()->id))
                                    <th colspan="2">Manage work</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $work)
                                <tr work="{{$work->id}}">
                                    <td class="day-field">{{$work->day}}</td>
                                    <td class="estimate-field"><input class="form-control"
                                                                      value="{{round($work->time_estimate_min / 60, 2)}}"
                                                                      disabled></td>
                                    <td class="amount-field"><input class="form-control"
                                                                    value="{{round($work->amount_min / 60, 2)}}"
                                                                    disabled></td>
                                    <td>
                                        @if($task->accepted !== 3 && ($task->user && $task->user->id === Auth::user()->id))
                                            <a class="btn btn-primary" type="button"
                                               onclick="edit_work({{$work}}, this)">Edit
                                                work</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->accepted !== 3 && ($task->user && $task->user->id === Auth::user()->id))
                                            <a class="btn btn-danger" type="button"
                                               onclick="delete_work({{$work}}, this)">Delete
                                                work</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        @if($task->accepted !== 3 && ($task->user && $task->user->id === Auth::user()->id))
                            <a class="btn btn-primary "
                               href="{{ route('work.create', [$project->id, $task->id]) }}" {{ Popper::arrow()->position('right')->pop('Create a new work log') }}>{{ __('Create new') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
