@extends('admin.master')
@section('head_style')
    <style>
        .stories-card__title, .stories-card .card-title, .stories-card .card-title > a {
            max-width: 350px;
        }
    </style>
@stop
@section('content')

@if (isset($voucher) && $voucher)
  <div class="row justify-content-center">
      <div class="col-4">
        <div class="card-header">
          <div class="form-group">
            <label for="event name">Event Name:</label>
            <input class="form-control" type="text" value="{{isset($voucher->event_name) && $voucher->event_name ? $voucher->event_name : ""}}" disabled>
          </div>
          <div class="form-group">
            <label for="event name">Percentage Decrease:</label>
            <input class="form-control" type="number" value="{{isset($voucher->percentage_decrease) && $voucher->percentage_decrease ? $voucher->percentage_decrease : ""}}" disabled>
          </div>
          <div class="form-group">
            <label for="event name">Expiry date:</label>
            <input class="form-control" type="date" value="{{isset($voucher->expiry_date) && $voucher->expiry_date ? date('d/m/Y', strtotime($voucher->expiry_date)) : ""}}" disabled>
          </div>
          <div class="form-group">
            <label for="event name">Status:</label>
            <input class="form-control" type="text" value="{{isset($voucher->status) && $voucher->status ? $voucher->status : ""}}" disabled>
          </div>
          <div class="form-group">
            <label for="event name">Code:</label>
            <input class="form-control" type="text" value="{{isset($voucher->unique_code) && $voucher->unique_code ? $voucher->unique_code : ""}}" disabled>
          </div>
          <div class="form-group">
            <label for="event name">Created at:</label>
            <input class="form-control" type="date" value="{{isset($voucher->created_at) && $voucher->created_at ? date('d/m/Y', strtotime($voucher->created_at)) : ""}}" disabled>
          </div>
        </div>
      </div>
      <div class="col-8 card">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">User Name</th>
              <th scope="col">Email</th>
              <th scope="col">Status</th>
              <th scope="col">Created_at</th>
            </tr>
          </thead>
          <tbody >
            @if (isset($users) && $users)
              @foreach ($users as $index => $user)
                <tr>
                  <th scope="col">{{$index}}</th>
                  <th scope="col">
                    <a href="/auth/personal-info?user_id={{isset($user->user_id) && $user->user_id ? $user->user_id : ""}}">
                      {{isset($user->user_name) && $user->user_name ? $user->user_name : ""}}
                    </a>
                  </th>
                  <th scope="col">{{isset($user->email) && $user->email ? $user->email : ""}}</th>
                  <th scope="col">{{isset($user->status) && $user->status ? $user->status : ""}}</th>
                  <th scope="col">{{isset($user->created_at) && $user->created_at ? date('d-m-Y',strtotime($user->created_at)) : ""}}</th>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        @if (isset($pagination) && $pagination)
          <div class="d-flex justify-content-center">
            <div class="paginate-item">
              {{ isset($pagination) && $pagination ? $pagination->links() : '' }}
            </div>
          </div>
        @endif
      </div>
  </div>
@else
  <div class="d-flex justify-content-center">
    <strong>The voucher is not existed</strong>
  </div>
@endif
@stop
<section>

</section>
@section('foot_script')
<script>

</script>
@stop