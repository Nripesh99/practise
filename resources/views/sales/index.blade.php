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
                            @if (Route::currentRouteName() === 'sales.all')
                            <th scope="col">Action</th>
                            @endif

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
                                @if (Route::currentRouteName() === 'sales.all')
                                <td>
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this sale?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                                {{-- {{$sales->user->name}} --}}
                                
                            </tr>
                            @php $s_no++   @endphp
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
