@extends('layouts.app')
@section('content')
    <div x-data="lottery()" class="content">
        <div class="row">
            <div class="col-7">
                <h1>{{ $lottery->title }}</h1>
            </div>
            <div class="col-5 text-end">
                <a href="{{ route('lottery.index') }}" class="btn btn-outline-primary">Back</a>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div x-show="message.length > 0" :class="'alert ' + message_class" x-text="message"></div>
                        </div>
                        <div class="col-12 mb-1">
                            Add tickets to player
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Player name" list="players" x-model="form.player_name" class="form-control" name="player_name">
                            <datalist id="players">
                                @foreach($players as $player)
                                    <option value="{{ $player }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <input type="number" placeholder="Number of tickets" x-model="form.number_of_tickets" :max="lottery.maximum_tickets_per_player" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-3">
                                <input type="number" placeholder="Ticket price" x-model.lazy="total_price" class="form-control">
                                <span class="input-group-text" id="basic-addon2">Gold</span>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <button class="btn btn-primary" x-on:click="addTickets()">Add tickets</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <template x-for="player in players">
                            <div class="col-md-12">
                                <span class="badge fs-6 bg-primary" >Player: <span x-text="player.name"></span></span>
                                <span class="badge fs-6 bg-secondary">Tickets: <span x-text="player.tickets.length"></span></span>
                                <span class="badge fs-6 bg-secondary">Golds: <span x-text="player.tickets.length * lottery.ticket_price"></span></span>
                                <br>
                                <template x-for="ticket in player.tickets">
                                    <span class="badge me-1 bg-success" x-text="ticket.ticket_number"></span>
                                </template>
                                <hr>
                            </div>

                        </template>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        function lottery() {
            return {
                init() {
                    this.$watch('form.number_of_tickets', (value) => {
                        if (value > this.lottery.maximum_tickets_per_player) {
                            this.form.number_of_tickets = this.lottery.maximum_tickets_per_player;
                        }
                    });

                    this.getPlayers();
                },
                form: {
                    player_name: '',
                    number_of_tickets: 1,
                },
                lottery: @json($lottery, JSON_THROW_ON_ERROR),
                players: [],
                message: '',
                message_class: '',
                addTickets() {
                    if (this.form.player_name.length === 0) {
                        this.message = 'Player name is required';
                        this.message_class = 'alert-danger';
                        return;
                    }

                    if (this.form.number_of_tickets <= 0) {
                        this.message = 'Number of tickets must be greater than 0';
                        this.message_class = 'alert-danger';
                        return;
                    }

                    axios.post('/lottery/' + this.lottery.id + '/tickets', this.form)
                        .then(response => {
                            this.form.player_name = '';
                            this.form.number_of_tickets = 1;
                            this.getPlayers();
                            this.message = response.data.message;
                            this.message_class = 'alert-success';
                        })
                        .catch(error => {
                            this.message = error.response.data.message;
                            this.message_class = 'alert-danger';
                        });

                    $('input[name="player_name"]').focus();
                },
                getPlayers() {
                    axios.get('/lottery/' + this.lottery.id + '/tickets')
                        .then(response => {
                            this.players = response.data.tickets;
                        })
                        .catch(error => {
                            this.message = error.response.data.message;
                            this.message_class = 'alert-danger';
                        });
                },

                get total_price() {
                    return this.lottery.ticket_price * this.form.number_of_tickets;
                },

                set total_price(value) {
                    this.form.number_of_tickets = Math.floor(value / this.lottery.ticket_price) ?? 1;
                }
            }
        }
    </script>
@endsection
