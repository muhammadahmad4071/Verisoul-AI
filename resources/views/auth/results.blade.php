@extends('layouts.app')

@section('content')
<div>
    <h1>{{ $results['decision'] === 'Real' ? 'Success!' : 'Require additional verification' }}</h1>
    <pre >{{ json_encode($results, JSON_PRETTY_PRINT) }}</pre>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection
