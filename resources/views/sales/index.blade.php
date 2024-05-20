@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($sales); --}}
                        @php
                            $s_no = 1;
                        @endphp
                        @foreach ($sales as $sale)
                            <tr>
                                <th scope="row">{{ $s_no }}</th>
                                <td>{{ $sale->name }}</td>
                                <td>{{$sale->amount}}</td>
                                <td>{{$sale->commission}}</td>
                                {{$sales->user->name}}
                                
                            </tr>
                            @php $s_no++   @endphp
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
