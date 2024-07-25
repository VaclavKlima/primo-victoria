@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-7">
                <h1>{{ $lottery->name ?? 'Create lottery' }}</h1>
            </div>
            <div class="col-5 text-end">
                <a href="{{ route('lottery.index') }}" class="btn btn-outline-primary">Back</a>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $lottery->id ? route('lottery.update', $lottery) : route('lottery.store') }}" method="POST">
                            @csrf
                            @if($lottery->id)
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $lottery->title ?? 'Lottery: ' . now()->format('d.m.Y')) }}" placeholder="Lottery">
                                </div>

                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="datetime-local" class="form-control" id="start_date"  name="start_date" value="{{ old('start_date', $lottery->start_date ?? now()) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $lottery->end_date ?? now()->addWeek()) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="owner_name" class="form-label">Owner Name</label>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name', $lottery->owner_name ?? 'Imonar') }}">
                                </div>

                                <!-- Maximum number of tickets  per player-->
                                <div class="col-md-4">
                                    <label for="maximum_tickets_per_player" class="form-label">Maximum number of tickets per player</label>
                                    <input type="number" class="form-control" id="maximum_tickets_per_player" name="maximum_tickets_per_player" value="{{ old('maximum_tickets_per_player', $lottery->maximum_tickets_per_player ?? 100000) }}">
                                </div>

                                <!-- Ticket price -->
                                <div class="col-md-4">
                                    <label for="ticket_price" class="form-label">Ticket price</label>
                                    <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="{{ old('ticket_price', $lottery->ticket_price ?? 100) }}">
                                </div>

                                <!-- Starting price -->
                                <div class="col-md-4">
                                    <label for="starting_price" class="form-label">Starting price</label>
                                    <input type="number" class="form-control" id="starting_price" name="starting_price" value="{{ old('starting_price', $lottery->starting_price ?? 100000) }}">
                                </div>

                                <!-- Chance to win -->
                                <div class="col-md-4">
                                    <label for="chance_to_win" class="form-label">% Chance to win</label>
                                    <input type="number" class="form-control" id="chance_to_win" name="chance_to_win" value="{{ old('chance_to_win', $lottery->chance_to_win ?? 50) }}">
                                </div>

                                <div class="col-md-4 text-end mt-2">
                                    <button type="submit" class="btn btn-primary mt-4">{{ $lottery->id ? 'Update' : 'Create' }}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
