@if (session('message'))
    {{ session('message') }}
@else
    <h1>Session หมดอายุ // มีการอนุมัติแล้ว</h1>
@endif