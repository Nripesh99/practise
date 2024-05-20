@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Fill out the form</div>
                    <div class="card-body">
                        
                        <form method="POST" action="{{route('sales.store')}}">
                            @csrf
    
                            <div class="form-group">
                                <label for="dropdown">Select an option:</label>
                                <select class="form-control" id="dropdown" name="user_id">
                                    @foreach($user as $users)
                                    <option value="{{$users->id}}">{{$users->name}}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount">
                            </div>
                            <div class="text-center mt-4">

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection
