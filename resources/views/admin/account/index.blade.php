@extends('admin.master')
@section('head_style')
    <style>
        .stories-card__title, .stories-card .card-title, .stories-card .card-title > a {
            max-width: 350px;
        }
    </style>
@stop
@section('content')
<div class="p-2">
    <a href="{{Request::url()}}/new" class="btn btn-success">Create Account</a>
</div>

<div class="row justify-content-center">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">User name</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Verified</th>
            <th scope="col">Created at</th>
          </tr>
        </thead>
        <tbody>
            @if (isset($accounts) && $accounts)
            @foreach ($accounts as $index => $account)
                <tr>
                    <th scope="row">{{$index+1}}</th>
                    <td>
                        <a href="{{Request::url()}}/{{isset($account->id) && $account->id ? $account->id : ""}}">
                            {{isset($account->user_name) && $account->user_name ? $account->user_name : ""}}
                        </a>
                    </td>
                    <td>
                        {{isset($account->name) && $account->name ? $account->name : ""}}
                    </td>
                    <td>
                        {{isset($account->email) && $account->email ? $account->email : ""}}
                    </td>
                    <td>
                        {{isset($account->email_verified_at) && $account->email_verified_at ? date('d/m/Y', strtotime($account->email_verified_at)) : "Not yet verified"}}
                    </td>
                    <td>
                        {{isset($account->created_at) && $account->created_at ? date('d/m/Y', strtotime($account->created_at)): ""}}
                    </td>
                </tr>
            @endforeach
            @endif
    </table>
    @if (isset($pagination) && $pagination )
    <div class="paginate-item">
        {{ isset($pagination) && $pagination ? $pagination->links() : '' }}
    </div>
    @endif
</div>
@stop
@section('foot_script')
<script>
    $(document).ready(function(){
        $(".select2").select2();

            
        function setResize(ele, base, css){
            $(`.${ele}`).css(`${css}`, $(`.${base}`).width() + "px");
            $(window).bind('resize', ()=>$(`.${ele}`).css(`${css}`, $(`.${base}`).width() + "px"));
        };
    });
</script>
@stop