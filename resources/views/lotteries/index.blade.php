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
                                    <th scope="col">Tickets sold</th>
                                    <th scope="col">% win</th>
                                    <th scope="col">Current price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lotteries as $lottery)
                                    <tr>
                                        <td>{{ $lottery->title }}</td>
                                        <td>{{ $lottery->start_date->format('d.m.Y H:i') }}</td>
                                        <td>{{ $lottery->end_date->format('d.m.Y H:i') }}</td>
                                        <td>{{ $lottery->tickets_count }}</td>
                                        <td>{{ $lottery->chance_to_win }}</td>
                                        <td>{{ number_format($lottery->current_price, 2,'.', ' ') }}</td>
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
                                    <td colspan="7">{{ $lotteries->links() }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
