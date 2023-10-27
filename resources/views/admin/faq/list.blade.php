@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-10 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Faq List</h3>
                <a href="{{ route('faq.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Create FAQ</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($lists as $sl=>$list)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $list->question }}</td>
                        <td>{{Str::substr( $list->answer, 0, 100).'...' }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('faq.show', $list->id) }}" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('faq.edit', $list->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                <form action="{{ route('faq.destroy', $list->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
