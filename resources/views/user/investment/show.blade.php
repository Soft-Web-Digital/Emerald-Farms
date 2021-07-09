@php
    use App\Http\Controllers\Globals as Util;
    $lastDate = null;
    $nextDate = null;
@endphp

@extends("layouts.user")

@section('title') Investments @endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Milestone</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($investment->milestoneDates() as $key => $date)

                                    @if($nextDate == null && $date->gt(now()))
                                        @php $nextDate = $date @endphp
                                    @endif
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{$date->format('l jS F, Y - h:i A')}}
                                        </td>
                                        <td>
                                            @if ($loop->last)
                                                NGN{{number_format(implode("", explode(',',$investment->amount_invested)) + (implode("", explode(',',$investment->milestoneReturns()))) ,2)}}
{{--                                                NGN{{number_format(implode("", explode(',',$investment->amount_invested)) + (implode("", explode(',',$investment->milestoneReturns())) / count($investment->milestoneDates())) ,2)}}--}}

                                                @php $lastDate = $date @endphp
                                            @else
{{--                                                NGN{{number_format(implode("", explode(',',$investment->milestoneReturns())) / count($investment->milestoneDates()),2)}}--}}
                                                NGN{{number_format(implode("", explode(',',$investment->milestoneReturns())),2)}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($date->gt(now()))
                                            <span class="badge badge-warning">Not matured</span>
                                            @else
                                                @if($investment->payments()->count() >= $key+1)
                                                <span class="badge badge-success">Paid</span>
                                                @else
                                                <span class="badge badge-warning">Pending Payment</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>General</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Number of Units</td>
                                        <td>
                                            {{$investment->units}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Farmlist</td>
                                        <td>
                                            {{$investment->farm->title}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>Investment Status</td>
                                        <td>
                                            @if(count($investment->payments) >= count($investment->milestoneDates()))
                                                <span class="badge badge-success">paid</span>
                                            @else
                                                @if(strtotime($lastDate) < strtotime(now()))
                                                    <span class="badge badge-success">completed</span>
                                                @else
                                                    <span class="badge badge-warning">pending</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>Maturity Status</td>
                                        <td>
                                            @if(strtotime($lastDate) < strtotime(now()))
                                                <span class="badge badge-success">completed</span>
                                            @else
                                                <span class="badge badge-warning">pending</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>5</td>
                                        <td>Number of Milestones</td>
                                        <td>
                                            {{$investment->farm->milestone}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>6</td>
                                        <td>Rollover</td>
                                        <td>
                                            {{$investment->rollover ? 'Yes' : 'No'}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Funds</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Amount Invested</td>
                                        <td>
                                            NGN {{ number_format(implode("", explode(',',$investment->amount_invested))) .'.00'}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Total ROI</td>
                                        <td>
                                            NGN {{ number_format(implode("", explode(',',$investment->amount_invested)) * ($investment->farm->interest / 100) * $investment->farm->milestone, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>ROI Percentage</td>
                                        <td>
                                            {{$investment->farm->interest}}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>Expected returns</td>
                                        <td>
                                            NGN {{number_format(implode("", explode(',',$investment->amount_invested)) + implode("", explode(',',$investment->amount_invested)) * ($investment->farm->interest / 100) * $investment->farm->milestone)}}

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Calendar</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Date Created</td>
                                    <td>
                                        {{$investment->created_at->format('D M Y')}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Next Payment Date</td>
                                    <td>
                                        {{ $nextDate == null ? $nextDate : $nextDate->format('l jS F, Y - h:i A')}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Days Remaining</td>
                                    <td>
                                        {{$lastDate->diffInDays(now())}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>Total Number of Days</td>
                                    <td>
                                        {{$investment->getPaymentDurationInDays()}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>Final Date</td>
                                    <td>
                                        {{$lastDate->format('l jS F, Y - h:i A')}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
