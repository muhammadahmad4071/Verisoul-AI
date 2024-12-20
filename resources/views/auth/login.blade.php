@extends('layouts.app')

@section('content')
<div>
    <h1>Login or Signup</h1>
    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('authenticate') }}">
        @csrf
        <input type="hidden" id="session_id" name="session_id">
        <label for="account_id">Account Identifier</label>
        <input type="text" id="account_id" name="account_id" required>
        <button type="submit">Submit</button>
    </form>
    <script>
        async function getSessionId() {
            if (!window.Verisoul) {
                alert('Verisoul script not loaded.');
                return;
            }
            const { session_id } = await window.Verisoul.session();
            document.getElementById('session_id').value = session_id;
        }

        document.querySelector('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            await getSessionId();
            e.target.submit();
        });
    </script>
</div>
@endsection
