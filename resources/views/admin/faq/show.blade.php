@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>FAQ Details</h3>
                    <a href="{{ route('faq.index') }}" class="btn btn-primary"><i class="fa fa-list"></i> FAQ List</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Question</td>
                            <td>{{ $faq->question }}</td>
                        </tr>
                        <tr>
                            <td>Answer</td>
                            <td>{{ $faq->answer }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

