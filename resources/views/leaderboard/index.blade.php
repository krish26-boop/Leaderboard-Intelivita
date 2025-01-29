@extends('layouts.app')

@section('content')
<div>
    <form method="POST" action="{{ route('leaderboard.recalculate') }}">
        @csrf
        <button type="submit" class="btn btn-success mb-3">Recalculate</button>
    </form>

    <form method="GET" action="{{ route('leaderboard') }}">
        <label for="user_id" class="mr-2 text-black">User ID:</label>
            <input type="number" name="user_id" id="user_id" value="{{ request('user_id') }}"   placeholder="Enter User ID">
        <label for="filter" class="ml-5 mr-2 text-black">Filter by:</label>
            <select name="filter" id="filter" class="p-2 border rounded text-black">
                <option value="day" {{ request('filter', 'day') == 'day' ? 'selected' : '' }}>Day</option>
                <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Month</option>
                <option value="year" {{ request('filter') == 'year' ? 'selected' : ''  }}>Year</option>
            </select>
        <button type="submit" class="btn btn-md btn-primary">Filter</button>
    </form>

    <table class="table table-bordered mt-5">
        <thead class="table-info">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Total Points</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankings as $ranking)
                <tr class="{{ request('user_id') == $ranking->user_id ? 'table-secondary' : '' }}">
                    <td>{{ $ranking->user->id }}</td>
                    <td>{{ $ranking->user->name }}</td>
                    <td>{{ $ranking->total_points }}</td>
                    <td>#{{ $ranking->rank }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
