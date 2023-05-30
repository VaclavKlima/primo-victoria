@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <!-- Page Heading with create button on the right-->
            <div class="col-7">
                <h1>Lotteries</h1>
            </div>
            <div class="col-5 text-end">
                <a href="{{ route('lottery.create') }}" class="btn btn-outline-primary">Create</a>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Draw Date</th>
                                    <th scope="col">Draw Time</th>
                                    <th scope="col">Winning Numbers</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lotteries as $lottery)
                                    <tr>
                                        <td>{{ $lottery->name }}</td>
                                        <td>{{ $lottery->draw_date }}</td>
                                        <td>{{ $lottery->draw_time }}</td>
                                        <td>{{ $lottery->winning_numbers }}</td>
                                        <td>
                                            <a href="{{ route('lottery.show', $lottery) }}" class="btn btn-primary">View</a>
                                            <a href="{{ route('lottery.edit', $lottery) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('lottery.destroy', $lottery) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">{{ $lotteries->links() }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
